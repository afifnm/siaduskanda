<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Pengaduan extends Model
{
    use HasFactory;

    public const STATUS_MASUK = 'masuk';

    public const STATUS_TERVERIFIKASI = 'terverifikasi';

    public const STATUS_DALAM_PROSES = 'dalam_proses';

    public const STATUS_MENUNGGU_KONFIRMASI = 'menunggu_konfirmasi';

    public const STATUS_SELESAI = 'selesai';

    public const STATUS_DITOLAK = 'ditolak';

    public const URGENSI_NORMAL = 'Normal';

    public const URGENSI_MENDESAK = 'Mendesak';

    public const URGENSI_BAHAYA = 'Ada risiko keselamatan';

    public const KATEGORI_SARPRAS = 'Sarana dan prasarana';

    public const KATEGORI_AKADEMIK = 'Pembelajaran dan akademik';

    public const KATEGORI_ADMINISTRASI = 'Layanan administrasi';

    public const KATEGORI_PERLINDUNGAN = 'Perlindungan warga sekolah';

    public const KATEGORI_ASPIRASI = 'Saran dan aspirasi';

    protected $fillable = [
        'ticket_number',
        'user_id',
        'kategori',
        'kategori_definitif',
        'jenis_pelapor',
        'nama_pelapor',
        'kontak',
        'is_anonim',
        'judul',
        'lokasi',
        'uraian',
        'urgensi_pelapor',
        'urgensi_admin',
        'bukti_pelapor',
        'status',
        'unit_tujuan',
        'petugas_id',
        'nama_petugas',
        'deadline',
        'catatan_admin',
        'catatan_petugas',
        'suku_cadang',
        'bukti_petugas',
        'admin_close_feedback',
        'rating',
        'ulasan_pelapor',
        'tanggal_lapor',
        'tanggal_selesai',
    ];

    protected function casts(): array
    {
        return [
            'is_anonim' => 'boolean',
            'rating' => 'integer',
            'deadline' => 'datetime',
            'tanggal_lapor' => 'datetime',
            'tanggal_selesai' => 'datetime',
        ];
    }

    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(PengaduanHistory::class, 'pengaduan_id')->orderBy('created_at', 'asc');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_MASUK => 'Menunggu Verifikasi',
            self::STATUS_TERVERIFIKASI => 'Terverifikasi (Ditugaskan)',
            self::STATUS_DALAM_PROSES => 'Sedang Ditangani Petugas',
            self::STATUS_MENUNGGU_KONFIRMASI => 'Menunggu Review Selesai',
            self::STATUS_SELESAI => 'Selesai Tuntas',
            self::STATUS_DITOLAK => 'Ditolak',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function getEffectiveUrgensiAttribute(): string
    {
        return $this->urgensi_admin ?: $this->urgensi_pelapor;
    }

    public function getStepIndexAttribute(): int
    {
        return match ($this->status) {
            self::STATUS_MASUK => 1,
            self::STATUS_TERVERIFIKASI => 2,
            self::STATUS_DALAM_PROSES => 3,
            self::STATUS_MENUNGGU_KONFIRMASI => 4,
            self::STATUS_SELESAI => 5,
            default => 1,
        };
    }

    public function getBuktiPelaporUrlAttribute(): ?string
    {
        if (! $this->bukti_pelapor) {
            return null;
        }

        if (str_starts_with($this->bukti_pelapor, 'http://') || str_starts_with($this->bukti_pelapor, 'https://')) {
            return $this->bukti_pelapor;
        }

        return Storage::disk('public')->url($this->bukti_pelapor);
    }

    public function getBuktiPetugasUrlAttribute(): ?string
    {
        if (! $this->bukti_petugas) {
            return null;
        }

        if (str_starts_with($this->bukti_petugas, 'http://') || str_starts_with($this->bukti_petugas, 'https://')) {
            return $this->bukti_petugas;
        }

        return Storage::disk('public')->url($this->bukti_petugas);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        $term = trim($term);

        return $query->where(function (Builder $q) use ($term) {
            $q->where('ticket_number', 'like', "%{$term}%")
                ->orWhere('judul', 'like', "%{$term}%")
                ->orWhere('nama_pelapor', 'like', "%{$term}%")
                ->orWhere('lokasi', 'like', "%{$term}%")
                ->orWhere('uraian', 'like', "%{$term}%");
        });
    }

    public function scopeFilterStatus(Builder $query, ?string $status): Builder
    {
        if (blank($status) || $status === 'all') {
            return $query;
        }

        return $query->where('status', $status);
    }

    public function scopeFilterKategori(Builder $query, ?string $kategori): Builder
    {
        if (blank($kategori) || $kategori === 'all') {
            return $query;
        }

        return $query->where('kategori', $kategori);
    }
}
