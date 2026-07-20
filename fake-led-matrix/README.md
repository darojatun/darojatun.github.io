# Running Text LED Matrix 64x8

Demo halaman HTML yang mensimulasikan running text pada LED matrix 64×8.

Cara pakai (sederhana):

1. Buka terminal di folder ini (`index.html`, `running.txt` ada di sini).
2. Jalankan server statis sederhana, contoh dengan Python:

```bash
python3 -m http.server 8000
```

3. Buka browser ke `http://localhost:8000/index.html`.
4. Edit file `running.txt` (di folder yang sama). Halaman akan mem-fetch file setiap 2 detik dan mengganti teks jika berubah.

Catatan:
- Jika browser meng-cache `running.txt`, fetch menggunakan query string `_=` dengan timestamp mencegah cache.
- Untuk memperlambat atau mempercepat scroll, edit `scrollMs` di `script.js`.
- Untuk memperbesar tampilan, ubah `--pixel-size` di `styles.css`.
