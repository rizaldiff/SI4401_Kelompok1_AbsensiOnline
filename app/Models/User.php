<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getTempatTanggalLahirAttribute()
    {
        return $this->tempat_lahir.', '.$this->tgl_lahir;
    }

    public function getShiftPegawaiAttribute()
    {
        switch ($this->bagian_shift) {
            case '1':
                return '<span class="badge badge-success">Full Time</span>';
                break;
            case '2':
                return '<span class="badge badge-warning">Part Time</span>';
                break;
            default:
                return '<span class="badge badge-primary">Shift Time</span>';
                break;
        }
    }

    public function getAkunDibuatAttribute()
    {
        return Carbon::parse($this->created_at)->translatedFormat('d F Y');
    }

    public function getLevelAttribute()
    {
        switch ($this->role_id) {
            case 1:
                return '<span class="badge badge-danger">Administrator</span>';
                break;
            case 2:
                return '<span class="badge badge-primary">Pegawai</span>';
                break;
            default:
                return '<span class="badge badge-dark">Unknown</span>';
                break;
        }
    }

    public function getShiftAttribute()
    {
        switch ($this->bagian_shift) {
            case 1:
                return '<span class="badge badge-success">Full Time</span>';
                break;
            case 2:
                return '<span class="badge badge-warning">Part Time</span>';
                break;
            default:
                return '<span class="badge badge-primary">Shift</span>';
                break;
        }
    }

    public function getVerificationAttribute()
    {
        switch ($this->is_active) {
            case 1:
                return '<span class="badge badge-success">Terverifikasi</span>';
                break;
            case 0:
                return '<span class="badge badge-danger">Belum Terverifikasi</span>';
                break;
            default:
                return '<span class="badge badge-dark">Unknown</span>';
                break;
        }
    }
}
