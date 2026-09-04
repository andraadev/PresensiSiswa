<?php

namespace Tests\Feature;

use App\Models\Counseling;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CounselingCRUDTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_index()
    {
        $response = $this->get('/bk/konseling');

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_index_displays_counseling_list_for_bk()
    {
        $user = User::create([
            'nama_lengkap' => 'BK User',
            'username' => 'bkuser',
            'password' => Hash::make('password'),
            'role' => 'BK',
            'is_active' => true,
        ]);

        $siswa = Siswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Siswa Test',
            'jenis_kelamin' => 'Laki-laki',
            'kelas_id' => null,
            'no_telepon' => '0812345678901',
            'status' => 'Aktif',
        ]);

        Counseling::create([
            'student_id' => $siswa->id,
            'created_by' => $user->id,
            'action_date' => now()->toDateString(),
            'action_type' => 'Konseling Individu',
            'problem_notes' => 'Keluhan contoh',
            'agreement_result' => 'Hasil contoh',
            'status' => 'Sedang Dipantau',
        ]);

        $this->actingAs($user)
            ->get('/bk/konseling')
            ->assertStatus(200)
            ->assertSee('Siswa Test')
            ->assertSee('Konseling Individu')
            ->assertSee('Sedang Dipantau');
    }

    public function test_store_creates_new_counseling()
    {
        $user = User::create([
            'nama_lengkap' => 'BK User',
            'username' => 'bkuser2',
            'password' => Hash::make('password'),
            'role' => 'BK',
            'is_active' => true,
        ]);

        $siswa = Siswa::create([
            'nisn' => '0987654321',
            'nama_lengkap' => 'Siswa Baru',
            'jenis_kelamin' => 'Perempuan',
            'kelas_id' => null,
            'no_telepon' => '0812345678902',
            'status' => 'Aktif',
        ]);

        $payload = [
            'student_id' => $siswa->id,
            'action_date' => now()->toDateString(),
            'action_type' => 'Panggilan Orang Tua',
            'problem_notes' => 'Masalah baru',
            'agreement_result' => 'Sepakat',
            'status' => 'Belum Ditangani',
        ];

        $this->actingAs($user)
            ->post('/bk/konseling', $payload)
            ->assertStatus(302)
            ->assertRedirect('/bk/konseling');

        $this->assertDatabaseHas('counselings', [
            'student_id' => $siswa->id,
            'created_by'   => $user->id,
            'action_type' => 'Panggilan Orang Tua',
            'problem_notes' => 'Masalah baru',
        ]);
    }

    public function test_store_fails_validation_when_required_fields_are_missing()
    {
        $user = User::create([
            'nama_lengkap' => 'BK User',
            'username' => 'bkuser2',
            'password' => Hash::make('password'),
            'role' => 'BK',
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->post('/bk/konseling', [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['student_id', 'action_date', 'action_type', 'problem_notes']);
    }

    public function test_store_fails_if_student_id_does_not_exist()
    {
        $user = User::create([
            'nama_lengkap' => 'BK User',
            'username' => 'bkuser2',
            'password' => Hash::make('password'),
            'role' => 'BK',
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->post('/bk/konseling', [
                'student_id' => 99999,
                'action_date' => now()->toDateString(),
                'action_type' => 'Konseling Individu',
                'problem_notes' => 'Test',
            ])
            ->assertSessionHasErrors('student_id');
    }

    public function test_update_edits_existing_counseling()
    {
        $user = User::create([
            'nama_lengkap' => 'BK User',
            'username' => 'bkuser3',
            'password' => Hash::make('password'),
            'role' => 'BK',
            'is_active' => true,
        ]);

        $siswa = Siswa::create([
            'nisn' => '1122334455',
            'nama_lengkap' => 'Siswa Ubah',
            'jenis_kelamin' => 'Laki-laki',
            'kelas_id' => null,
            'no_telepon' => '0812345678903',
            'status' => 'Aktif',
        ]);

        $counseling = Counseling::create([
            'student_id' => $siswa->id,
            'created_by' => $user->id,
            'action_date' => now()->toDateString(),
            'action_type' => 'Konseling Individu',
            'problem_notes' => 'Keluhan awal',
            'agreement_result' => 'Belum',
            'status' => 'Belum Ditangani',
        ]);

        $update = [
            'student_id' => $siswa->id,
            'action_date' => now()->toDateString(),
            'action_type' => 'Kunjungan Rumah',
            'problem_notes' => 'Keluhan diperbarui',
            'agreement_result' => 'Selesai',
            'status' => 'Selesai',
        ];

        $this->actingAs($user)
            ->put('/bk/konseling/' . $counseling->id, $update)
            ->assertStatus(302)
            ->assertRedirect('/bk/konseling');

        $this->assertDatabaseHas('counselings', [
            'id' => $counseling->id,
            'action_type' => 'Kunjungan Rumah',
            'status' => 'Selesai',
        ]);
    }
}
