package repository

import (
	"latihan-fiber-api/internal/config"
	"latihan-fiber-api/internal/model"
)

type ProgramStudiDenganJumlahMahasiswa struct {
	model.ProgramStudi
	JumlahMahasiswa int64 `json:"jumlah_mahasiswa" gorm:"column:jumlah_mahasiswa"`
}

func AmbilProgramStudi() ([]ProgramStudiDenganJumlahMahasiswa, error) {
	daftar := make([]ProgramStudiDenganJumlahMahasiswa, 0)

	err := config.DB.Model(&model.ProgramStudi{}).
		Select("program_studis.*, (SELECT COUNT(*) FROM mahasiswas WHERE mahasiswas.program_studi_id = program_studis.id) AS jumlah_mahasiswa").
		Order("program_studis.nama ASC").
		Scan(&daftar).Error

	return daftar, err
}
