package config

import (
	"log"

	"latihan-fiber-api/internal/model"
)

func Migrasi() {
	err := DB.AutoMigrate(&model.ProgramStudi{}, &model.Mahasiswa{}, &model.Matakuliah{})
	if err != nil {
		log.Fatal("Gagal menjalankan migrasi: ", err)
	}

	log.Println("Migrasi selesai")
}

func DataAwal() error {
	daftarProgramStudi := []model.ProgramStudi{
		{Kode: "TK", Nama: "Teknik Komputer", Jenjang: "S1"},
		{Kode: "IF", Nama: "Informatika", Jenjang: "S1"},
		{Kode: "TE", Nama: "Teknik Elektro", Jenjang: "S1"},
	}

	idProgramStudi := make(map[string]uint, len(daftarProgramStudi))
	for _, programStudi := range daftarProgramStudi {
		var tersimpan model.ProgramStudi
		err := DB.Where("kode = ?", programStudi.Kode).
			FirstOrCreate(&tersimpan, programStudi).Error
		if err != nil {
			return err
		}
		idProgramStudi[programStudi.Kode] = tersimpan.ID
	}

	var jumlahMahasiswa int64
	if err := DB.Model(&model.Mahasiswa{}).Count(&jumlahMahasiswa).Error; err != nil {
		return err
	}
	if jumlahMahasiswa == 0 {
		daftarMahasiswa := []model.Mahasiswa{
			{
				ProgramStudiID: idProgramStudi["IF"],
				Nim:            "H1A123001",
				Nama:           "Andi Prasetyo",
				Email:          "andi.prasetyo@example.com",
				Angkatan:       2023,
				Ipk:            3.45,
			},
			{
				ProgramStudiID: idProgramStudi["IF"],
				Nim:            "H1A123002",
				Nama:           "Bunga Lestari",
				Email:          "bunga.lestari@example.com",
				Angkatan:       2023,
				Ipk:            3.80,
			},
			{
				ProgramStudiID: idProgramStudi["TK"],
				Nim:            "H1A124003",
				Nama:           "Citra Ramadhani",
				Email:          "citra.ramadhani@example.com",
				Angkatan:       2024,
				Ipk:            3.20,
			},
		}
		if err := DB.Create(&daftarMahasiswa).Error; err != nil {
			return err
		}
		log.Println("Data awal mahasiswa dibuat")
	}

	var jumlahMatakuliah int64
	if err := DB.Model(&model.Matakuliah{}).Count(&jumlahMatakuliah).Error; err != nil {
		return err
	}
	if jumlahMatakuliah == 0 {
		daftarMatakuliah := []model.Matakuliah{
			{
				ProgramStudiID: idProgramStudi["IF"],
				Kode:           "IF101",
				Nama:           "Algoritma dan Pemrograman",
				SKS:            3,
				Semester:       1,
			},
			{
				ProgramStudiID: idProgramStudi["IF"],
				Kode:           "IF201",
				Nama:           "Basis Data",
				SKS:            3,
				Semester:       2,
			},
			{
				ProgramStudiID: idProgramStudi["TK"],
				Kode:           "TK101",
				Nama:           "test",
				SKS:            2,
				Semester:       1,
			},
		}
		if err := DB.Create(&daftarMatakuliah).Error; err != nil {
			return err
		}
		log.Println("Data awal matakuliah dibuat")
	}

	log.Println("Data awal program studi siap")
	return nil
}
