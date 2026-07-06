<?php
 
namespace App\Http\Requests;
 
use Illuminate\Foundation\Http\FormRequest;
 
class StoreBukuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
 
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        // 1. Aturan Dasar & Pemanggilan Custom Rule Kode Buku
        $rules = [
            'kode_buku' => ['required', 'string', 'unique:buku,kode_buku', new \App\Rules\KodeBukuFormat()],
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'pengarang' => 'required|string',
            'penerbit' => 'required|string',
            'bahasa' => 'required|string',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|integer|min:0',
            'isbn' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string',
        ];

        // 2. Conditional Validation (Sesuai Spesifikasi Dosen)
        
        // Kondisi A: Jika kategori "Programming", bahasa harus "Inggris"
        if ($this->kategori == 'Programming') {
            $rules['bahasa'] .= '|in:Inggris';
        }

        // Kondisi B: Jika tahun terbit < 2000, stok maksimal 5
        if ($this->tahun_terbit < 2000) {
            $rules['stok'] .= '|max:5';
        }

        return $rules;
    }

    // 3. Custom Error Messages Indonesia
    public function messages(): array
    {
        return [
            // Pesan Error Umum
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'integer' => 'Kolom :attribute harus berupa angka.',
            'unique' => 'Kolom :attribute sudah terdaftar, silakan gunakan yang lain.',
            
            // Pesan Error Spesifik (Kondisional)
            'bahasa.in' => 'Untuk kategori Programming, bahasa buku wajib "Inggris".',
            'stok.max' => 'Buku terbitan di bawah tahun 2000 maksimal stoknya adalah 5.',
        ];
    }
 
    /**
     * Get custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'kode_buku' => 'kode buku',
            'judul' => 'judul buku',
            'kategori' => 'kategori',
            'pengarang' => 'nama pengarang',
            'penerbit' => 'nama penerbit',
            'tahun_terbit' => 'tahun terbit',
            'isbn' => 'ISBN',
            'harga' => 'harga',
            'stok' => 'stok',
            'bahasa' => 'bahasa',
        ];
    }
}