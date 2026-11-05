package handler

import (
	"latihan-fiber-api/internal/model"
	"sort"
	"strconv"

	"github.com/gofiber/fiber/v3"
)

func DaftarMahasiswa(c fiber.Ctx) error {
	angkatan := c.Query("angkatan", "")
	var nilaiAngkatan int
	if angkatan != "" {
		var err error
		nilaiAngkatan, err = strconv.Atoi(angkatan)
		if err != nil {
			return fiber.NewError(fiber.StatusBadRequest, "Parameter angkatan harus berupa angka")
		}
	}
	hasil := make([]model.Mahasiswa, 0, len(model.Daftar))
	for i := 0; i < len(model.Daftar); i++ {
		if angkatan == "" || model.Daftar[i].Angkatan == nilaiAngkatan {
			hasil = append(hasil, model.Daftar[i])
		}
	}
	switch urut := c.Query("urut", ""); urut {
	case "":
	case "nama":
		sort.SliceStable(hasil, func(i, j int) bool {
			return hasil[i].Nama < hasil[j].Nama
		})
	case "ipk":
		sort.SliceStable(hasil, func(i, j int) bool {
			return hasil[i].Ipk > hasil[j].Ipk // descending
		})
	default:
		return fiber.NewError(fiber.StatusBadRequest, "Parameter urut harus berupa nama atau ipk")
	}
	return c.JSON(fiber.Map{
		"sukses": true,
		"data":   hasil,
	})
}
func DetailMahasiswa(c fiber.Ctx) error {
	id, err := strconv.Atoi(c.Params("id"))
	if err != nil {
		return fiber.NewError(fiber.StatusBadRequest, "ID harus berupa angka")
	}
	for i := 0; i < len(model.Daftar); i++ {
		if model.Daftar[i].ID == id {
			return c.JSON(fiber.Map{
				"sukses": true,
				"data":   model.Daftar[i],
			})
		}
	}
	return fiber.NewError(fiber.StatusNotFound, "Mahasiswa tidak ditemukan")
}
func NimMahasiswa(c fiber.Ctx) error {
	nim := c.Params("nim")
	if nim == "" {
		return fiber.NewError(fiber.StatusBadRequest, "NIM wajib diisi")
	}
	for i := 0; i < len(model.Daftar); i++ {
		if model.Daftar[i].Nim == nim {
			return c.JSON(fiber.Map{
				"sukses": true,
				"data":   model.Daftar[i],
			})
		}
	}
	return fiber.NewError(fiber.StatusNotFound, "Mahasiswa tidak ditemukan")
}
