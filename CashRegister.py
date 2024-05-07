import datetime

print('Cash Register')
print('=============')

nama = input('Nama Pelanggan : ')
tanggal = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
print('Tanggal Pembelian  :', tanggal)
print('=============')
print('              ======Menu======            ')
print('1. Ayam Mayo                    Rp. 14000 ')
print('2. Ayam Katsu                   Rp. 15000 ')
print('3. Ayam Koloke                  Rp. 16000 ')
print('4. Ayam Bakar                   Rp. 17000 ')
print('              ======Menu======            ')

pesanan = []

while True:
    menu_pesanan = int(input('Masukan menu pesanan (nomor menu) : '))
    if menu_pesanan in [1, 2, 3, 4]:
        if menu_pesanan == 1:
            harga = 14000
        elif menu_pesanan == 2:
            harga = 15000
        elif menu_pesanan == 3:
            harga = 16000
        elif menu_pesanan == 4:
            harga = 17000
        pesanan.append({'menu': menu_pesanan, 'nama': 'Ayam Mayo' if menu_pesanan == 1 else 'Ayam Katsu' if menu_pesanan == 2 else 'Ayam Koloke' if menu_pesanan == 3 else 'Ayam Bakar', 'harga': harga})
        break
    else:
        print('Menu tidak tersedia. Silahkan pilih menu lainnya.')

jumlah_p = int(input('Masukan jumlah pembelian : '))
pesanan[-1]['jumlah'] = jumlah_p

while True:
    question = input('Apakah ada yang ingin ditambah/dikurangi ?\nPilihan Tambah/Kurang/Tidak\nPilihan anda : ')
    if question.lower() == 'tambah':
        tambah = int(input('Masukan menu pesanan (nomor menu) : '))
        if tambah in [1, 2, 3, 4]:
            if tambah == 1:
                harga = 14000
            elif tambah == 2:
                harga = 15000
            elif tambah == 3:
                harga = 16000
            elif tambah == 4:
                harga = 17000
            jumlah_t = int(input('Masukan jumlah pembelian : '))
            pesanan.append({'menu': tambah, 'nama': 'Ayam Mayo' if tambah == 1 else 'Ayam Katsu' if tambah == 2 else 'Ayam Koloke' if tambah == 3 else 'Ayam Bakar', 'harga': harga, 'jumlah': jumlah_t})
            print('Pesanan berhasil ditambahkan!')
        else:
            print('Menu tidak tersedia. Silahkan pilih menu lainnya.')
    elif question.lower() == 'kurang':
        while True:
            print('===== Pesanan Anda =====')
            total_pembayaran = 0
            for index, item in enumerate(pesanan, start=1):
                print(f"{index}. Menu: {item['nama']}, Jumlah: {item['jumlah']}, Harga: Rp.{item['harga'] * item['jumlah']}")
                total_pembayaran += item['harga'] * item['jumlah']
            print('========================')
            kurang_index = int(input('Pilih nomor pesanan yang ingin dikurangi: ')) - 1
            if kurang_index < 0 or kurang_index >= len(pesanan):
                print('Nomor pesanan tidak valid. Silahkan pilih nomor pesanan yang benar.')
                continue
            kurang_jumlah = int(input('Masukkan jumlah yang ingin dikurangi: '))
            if kurang_jumlah <= 0 or kurang_jumlah > pesanan[kurang_index]['jumlah']:
                print('Jumlah yang dimasukkan tidak valid. Silahkan masukkan jumlah yang benar.')
                continue
            if kurang_jumlah < pesanan[kurang_index]['jumlah']:
                pesanan[kurang_index]['jumlah'] -= kurang_jumlah
                print('Pesanan berhasil dikurangi!')
            elif kurang_jumlah == pesanan[kurang_index]['jumlah']:
                pesanan.pop(kurang_index)
                print('Pesanan berhasil dihapus karena jumlah kurang menjadi 0!')
            break
    elif question.lower() == 'tidak':
        total_pembayaran = sum(item['harga'] * item['jumlah'] for item in pesanan)
        print('========================')
        print('===== Pesanan Anda =====')
        for index, item in enumerate(pesanan, start=1):
            print(f"{index}. Menu: {item['nama']}, Jumlah: {item['jumlah']}, Harga: Rp.{item['harga'] * item['jumlah']}")
        print('========================')
        print(f'Total Pembayaran: Rp.{total_pembayaran}')

        while True:
            uang_dibayar = int(input('Masukkan jumlah uang yang dibayarkan : '))
            if uang_dibayar >= total_pembayaran:
                kembalian = uang_dibayar - total_pembayaran
                print(f'Uang Kembalian Anda : Rp.{kembalian}')
                break
            else:
                print('Jumlah uang yang dibayarkan kurang. Mohon masukkan kembali.')

        print('Terima kasih telah berbelanja!')
        
        # Menampilkan informasi lengkap setelah pembayaran
        print()
        print('Nama Pelanggan:', nama)
        print('Tanggal Pembelian:', tanggal)
        print('===== Pesanan Anda =====')
        for index, item in enumerate(pesanan, start=1):
            print(f"{index}. Menu: {item['nama']}, Jumlah: {item['jumlah']}, Harga: Rp.{item['harga'] * item['jumlah']}")
        print('========================')
        print(f'Total Pembayaran: Rp.{total_pembayaran}')
        print(f'Jumlah Uang yang Dibayar: Rp.{uang_dibayar}')
        print(f'Uang Kembalian Anda : Rp.{kembalian}')
        break
    else:
        print('Pilihan tidak valid. Silahkan pilih Tambah/Kurang/Tidak.')
