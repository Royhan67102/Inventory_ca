# Alur Order Sistem Inventory - Final

## Ringkasan Alur
Semua order harus melewati tahap **Produksi**, dengan Design sebagai tahap opsional sebelum Production.

```
Order → Desain (opsional) → Produksi (WAJIB) → Pickup/Pengiriman → Selesai
```

---

## 1. Create Order

### Scenario A: Custom dengan Jasa Desain (jasa_desain = "1")
```
Create Order
├── Status = "desain"
├── Design record dibuat
└── ❌ Production TIDAK dibuat sekarang (akan saat desain selesai)
```

### Scenario B: Custom tanpa Jasa Desain (jasa_desain = "0") atau Tipe Lembaran
```
Create Order
├── Status = "produksi"
└── Production record dibuat
```

**Key Point:** Status hanya bisa "desain" atau "produksi", BUKAN "pickup" atau "delivery".

---

## 2. Design → Production (Transisi Wajib)

**Event:** Design status berubah ke "selesai"

**Otomatis (Design.php updating event):**
```php
Design.status = "selesai" →
  - Buat Production record
  - Order.status = "produksi"
  - Production siap untuk dikerjakan
```

---

## 3. Production → Pickup/Pengiriman

**Event:** Production status berubah ke "selesai"

**Otomatis (Production.php updating event):**
```php
Production.status = "selesai" → {
  Jika Order.antar_barang = 1:
    - Buat DeliveryNote
    - Order.status = "delivery"
    - Hapus Pickup jika ada
  
  Jika Order.antar_barang = 0:
    - Buat Pickup
    - Order.status = "pickup"
    - Hapus DeliveryNote jika ada
}
```

---

## 4. Pickup/Pengiriman → Selesai

**Pickup:**
```php
Pickup.status = "selesai" → Order.status = "selesai"
```

**DeliveryNote:**
```php
DeliveryNote.status = "selesai" → Order.status = "selesai"
```

---

## Diagram Visual

```
          ┌─────────────▶ Custom + Desain
          │                    │
          │              (selesai)
          │                    │
CREATE ──┤                     ▼
ORDER    │              PRODUCTION
          │ ◀─────────────────┘
          │
          └─────────────▶ Custom - Desain / Lembaran
                              │
                        PRODUCTION
                              │
                        (selesai)
                              │
                      ┌───────┴────────┐
                      ▼                ▼
                  (antar=1)        (antar=0)
                      │                │
                  DELIVERY           PICKUP
                      │                │
                   (selesai)        (selesai)
                      │                │
                      └────────┬───────┘
                              │
                          SELESAI
                          (Dashboard)
```

---

## File yang Diperbaiki

### Models
- `app/Models/Design.php` - Update Design.status → Production creation
- `app/Models/Production.php` - Update Production.status → Pickup/Delivery creation
- `app/Models/Pickup.php` - Update Pickup.status → Order.status = selesai
- `app/Models/DeliveryNote.php` - Update DeliveryNote.status → Order.status = selesai

### Controllers
- `app/Http/Controllers/OrderController.php` - Store & Update with new flow
- `app/Http/Controllers/DesignController.php` - Comment updated

---

## Testing

✅ Order custom + desain → Status desain, Design ada
✅ Order custom - desain → Status produksi, Production ada
✅ Order lembaran → Status produksi, Production ada
✅ Design.selesai → Production dibuat, status produksi
✅ Production.selesai (antar=1) → DeliveryNote dibuat, status delivery
✅ Production.selesai (antar=0) → Pickup dibuat, status pickup
✅ Pickup.selesai → Order status selesai
✅ DeliveryNote.selesai → Order status selesai
