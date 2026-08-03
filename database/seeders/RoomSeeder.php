<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [

            [
                'id' => 'R001',
                'kode_ruang' => 'A101',
                'nama_ruang' => 'Ruang Kuliah A101',
                'gedung' => 'Gedung A',
                'lantai' => 1,
                'kapasitas' => 40,
                'fasilitas' => 'LCD, AC',
                'status' => 'Aktif'
            ],

            [
                'id' => 'R002',
                'kode_ruang' => 'A102',
                'nama_ruang' => 'Ruang Kuliah A102',
                'gedung' => 'Gedung A',
                'lantai' => 1,
                'kapasitas' => 35,
                'fasilitas' => 'LCD, AC'
            ],

            [
                'id' => 'R003',
                'kode_ruang' => 'A201',
                'nama_ruang' => 'Ruang Kuliah A201',
                'gedung' => 'Gedung A',
                'lantai' => 2,
                'kapasitas' => 50,
                'fasilitas' => 'LCD, AC'
            ],

            [
                'id' => 'R004',
                'kode_ruang' => 'B101',
                'nama_ruang' => 'Ruang Kuliah B101',
                'gedung' => 'Gedung B',
                'lantai' => 1,
                'kapasitas' => 45,
                'fasilitas' => 'LCD, AC'
            ],

            [
                'id' => 'R005',
                'kode_ruang' => 'B102',
                'nama_ruang' => 'Ruang Kuliah B102',
                'gedung' => 'Gedung B',
                'lantai' => 1,
                'kapasitas' => 30,
                'fasilitas' => 'LCD'
            ],

            [
                'id' => 'R006',
                'kode_ruang' => 'B201',
                'nama_ruang' => 'Ruang Kuliah B201',
                'gedung' => 'Gedung B',
                'lantai' => 2,
                'kapasitas' => 60,
                'fasilitas' => 'LCD, AC'
            ],

            [
                'id' => 'R007',
                'kode_ruang' => 'LAB01',
                'nama_ruang' => 'Lab Komputer 1',
                'gedung' => 'Gedung C',
                'lantai' => 1,
                'kapasitas' => 30,
                'fasilitas' => 'Komputer, LCD'
            ],

            [
                'id' => 'R008',
                'kode_ruang' => 'LAB02',
                'nama_ruang' => 'Lab Komputer 2',
                'gedung' => 'Gedung C',
                'lantai' => 2,
                'kapasitas' => 30,
                'fasilitas' => 'Komputer, LCD'
            ],

            [
                'id' => 'R009',
                'kode_ruang' => 'SEM01',
                'nama_ruang' => 'Ruang Seminar',
                'gedung' => 'Gedung D',
                'lantai' => 1,
                'kapasitas' => 120,
                'fasilitas' => 'LCD, Sound'
            ],

            [
                'id' => 'R010',
                'kode_ruang' => 'AUD01',
                'nama_ruang' => 'Auditorium',
                'gedung' => 'Gedung E',
                'lantai' => 1,
                'kapasitas' => 500,
                'fasilitas' => 'Sound, Proyektor'
            ],

        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
