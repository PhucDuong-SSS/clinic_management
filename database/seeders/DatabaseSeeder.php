<?php

namespace Database\Seeders;

use App\Models\Lot;
use App\Models\Unit;
use App\Models\User;
use App\Models\Patient;
use App\Models\Sympton;
use App\Models\Medicine;
use App\Models\medCategory;
use App\Models\Permission;
use Faker\Factory as Faker;
use App\Models\Prescription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker  = Faker::create();

        foreach (range(1, 30) as $index) {
            DB::table('med_categories')->insert([
                'med_category_name' => $faker->word,
                'description' => $faker->paragraph(1)
            ]);
        }


        foreach (range(1, 3) as $index) {
            DB::table('units')->insert([
                'name' => $faker->randomElement(['vỉ', 'chai', 'ống']),
            ]);
        }

        foreach (range(1, 10) as $index) {
            DB::table('lots')->insert([
                'code' => $faker->unique()->word,
                'unit_price' => 10000,
                'expired_date' => $faker->dateTimeBetween($startDate = 'now + 2 years', $endDate = 'now + 3 years'),
                'receipt_date' => $faker->dateTimeBetween($startDate = '- 1 year', $endDate = 'now'),
                'total_price' => 1000000,
            ]);
        }

        foreach (range(1, 20) as $index) {
            $categories = medCategory::all();
            $lots = Lot::all();
            $units = Unit::all();
            DB::table('medicines')->insert([
                'medicine_name' => $faker->unique()->word,
                'medicine_amount' => 100,
                'sell_price' => 12000,
                'id_category' => $categories->random()->id,
                'id_lot' => $lots->random()->id,
                'id_unit' => $units->random()->id,
                'image' => 'noimage.jpg',
                'unit_volume' => 100,
            ]);
        }

        foreach (range(1, 20) as $index) {

            DB::table('patients')->insert([
                'full_name' => $faker->name,
                'phone_number' => $faker->phoneNumber,
                'gender' => $faker->randomElement([0, 1]),
                'address' => $faker->address,
                'dob' => $faker->dateTimeBetween($startDate = 'now - 2 years', $endDate = 'now + 3 years'),
                'guardian_name' => $faker->name,
            ]);
        }

        foreach (range(1, 5) as $index) {

            DB::table('symptons')->insert([
                'sympton_name' => $faker->unique()->name,
            ]);
        }


        foreach (range(1, 20) as $index) {
            $patients = Patient::all();
            $symptons = Sympton::all();

            DB::table('prescriptions')->insert([
                'id_patient' => $patients->random()->id,
                'sympton' => $symptons->random()->sympton_name,
                'prognosis' => $faker->text,
                'exam_date' => $faker->dateTimeBetween($startDate = 'now - 2 years', $endDate = 'now'),
                'exam_price' => 50000,
                'note' => $faker->text,
            ]);
            $id_medicine = Medicine::all()->random()->id;

            DB::table('prescription_medicine')->insert([
                'id_prescrition' => $index,
                'id_medicine' => $id_medicine,
                'amount' => 10,
                'morning' => 1,
                'afternoon' => 1,
                'evening' => 1,
                'note_morning' => '1213',
                'note_midday' => '1213',
                'note_evening' => '1213',
                'number_of_day' => 5,
                'sell_price' => 12000,
                'unit_sell_price' => 10000,
                'sell_mode' => 'original'
            ]);
        }

        $permission = new Permission();
        $permission->permission_name = "list_user";
        $permission->permission_name2 = "Danh sách thành viên";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "edit_user";
        $permission->permission_name2 = "Chỉnh sửa thành viên";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "delete_user";
        $permission->permission_name2 = "Xóa thành viên";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "add_user";
        $permission->permission_name2 = "Thêm thành viên";
        $permission->save();

        $user = new User();
        $user->full_name = "admin";
        $user->email = "admin@gmail.com";
        $user->user_name = "admin";
        $user->password = bcrypt('123456@Abc');
        $user->address = "hue";
        $user->phone = "01111";
        $user->image   = "image.jpg";
        $user->save();

        $permission = Permission::all();
        foreach ($permission as $key => $permissionId) {
            DB::table('user_permission')->insert([
                'id_user' => $user->id,
                'permission_key' => $key + 1
            ]);
        }
    }
}
