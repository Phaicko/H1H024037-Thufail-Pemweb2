package middleware

import (
	"crypto/subtle"

	"github.com/gofiber/fiber/v3"
)

func KunciApi(apiKey string) fiber.Handler {
	return func(c fiber.Ctx) error {
		kunciPermintaan := c.Get("X-Api-Key")
		if len(kunciPermintaan) != len(apiKey) ||
			subtle.ConstantTimeCompare([]byte(kunciPermintaan), []byte(apiKey)) != 1 {
			return fiber.NewError(fiber.StatusUnauthorized, "API key tidak valid")
		}
		return c.Next()
	}
}
