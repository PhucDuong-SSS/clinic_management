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
use App\Models\Roles;
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
                'unit_name' => $faker->randomElement(['vỉ', 'chai', 'ống']),
            ]);
        }


        foreach (range(1, 20) as $index) {
            $categories = medCategory::all();
            // $lots = Lot::all();
            $units = Unit::all();
            DB::table('medicines')->insert([
                'medicine_name' => $faker->unique()->word,
                'medicine_amount' => 100,
                'sell_price' => 12000,
                'id_category' => $categories->random()->id,
                // 'id_lot' => $lots->random()->id,
                'id_unit' => $units->random()->id,
                'image' => 'noimage.jpg',
                // 'unit_volume' => 100,
            ]);
        }

        foreach (range(1, 10) as $index) {
            $medicines = Medicine::all();
            DB::table('lots')->insert([
                'code' => $faker->unique()->word,
                'id_med' =>  $medicines->random()->id,
                'medicine_amount' => 50,
                'unit_price' => 10000,
                'expired_date' => $faker->dateTimeBetween($startDate = 'now + 2 years', $endDate = 'now + 3 years'),
                'receipt_date' => $faker->dateTimeBetween($startDate = '- 1 year', $endDate = 'now'),
                'total_price' => 1000000,
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
        $permission->display_name = "Danh sách thành viên";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "edit_user";
        $permission->display_name = "Chỉnh sửa thành viên";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "delete_user";
        $permission->display_name = "Xóa thành viên";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "add_user";
        $permission->display_name = "Thêm thành viên";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "list_role";
        $permission->display_name = "Danh sách quyền";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "add_role";
        $permission->display_name = "Thêm quyền";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "edit_role";
        $permission->display_name = "Sửa quyền";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "delete_role";
        $permission->display_name = "Xóa quyền";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "list_unit";
        $permission->display_name = "Danh sách đơn vị";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "add_unit";
        $permission->display_name = "Thêm đơn vị";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "edit_unit";
        $permission->display_name = "Sửa đơn vị";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "delete_unit";
        $permission->display_name = "Xóa đơn vị";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "list_med";
        $permission->display_name = "Danh sách thuốc";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "add_med";
        $permission->display_name = "Thêm thuốc";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "edit_med";
        $permission->display_name = "Sửa thuốc";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "delete_med";
        $permission->display_name = "Xóa thuốc";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "list_almostOver";
        $permission->display_name = "Danh sách thuốc sắp hết";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "list_lot";
        $permission->display_name = "Danh sách nhập kho";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "add_lot";
        $permission->display_name = "Nhập thêm thuốc";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "edit_lot";
        $permission->display_name = "Sửa nhập thuốc";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "delete_lot";
        $permission->display_name = "Xóa nhập thuốc";
        $permission->save();

        $permission = new Permission();
        $permission->permission_name = "list_symton";
        $permission->display_name = "Danh sách triệu chứng";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "add_symton";
        $permission->display_name = "Thêm triệu chứng";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "edit_symton";
        $permission->display_name = "Sửa triệu chứng";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "delete_symton";
        $permission->display_name = "Xóa triệu chứng";
        $permission->save();

        $permission = new Permission();
        $permission->permission_name = "list_setting";
        $permission->display_name = "Danh sách cấu hình";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "add_setting";
        $permission->display_name = "Thêm cấu hình";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "edit_setting";
        $permission->display_name = "Sửa cấu hình";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "delete_setting";
        $permission->display_name = "Xóa cấu hình";
        $permission->save();

        $permission = new Permission();
        $permission->permission_name = "list_medCategory";
        $permission->display_name = "Danh sách danh mục";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "add_medCategory";
        $permission->display_name = "Thêm danh mục";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "edit_medCategory";
        $permission->display_name = "Sửa danh mục";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "delete_medCategory";
        $permission->display_name = "Xóa danh mục";
        $permission->save();

        $permission = new Permission();
        $permission->permission_name = "list_prescription";
        $permission->display_name = "Danh sách đơn thuốc";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "add_prescription";
        $permission->display_name = "Thêm đơn thuốc";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "delete_prescription";
        $permission->display_name = "Xóa đơn thuốc";
        $permission->save();

        $permission = new Permission();
        $permission->permission_name = "print_prescription";
        $permission->display_name = "In đơn thuốc";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "word_prescription";
        $permission->display_name = "Xuất đơn thuốc";
        $permission->save();
        $permission = new Permission();
        $permission->permission_name = "report_revenue";
        $permission->display_name = "Xem doanh thu";
        $permission->save();

        $user = new User();
        $user->full_name = "admin";
        $user->email = "admin@gmail.com";
        $user->user_name = "admin123";
        $user->password = bcrypt('123456@Abc');
        $user->address = "hue";
        $user->phone = "01111";
        $user->image   = "image.jpg";
        $user->save();

        $role = new Roles();
        $role->role_name = "admin";
        $role->display_name = "ADMIN";
        $role->save();

        DB::table('user_role')->insert([
            'id_user' => $user->id,
            'role_key' =>  1
        ]);

        $permission = Permission::all();
        foreach ($permission as $key => $permissionId) {
            DB::table('role_permission')->insert([
                'role_key' => 1,
                'permission_key' => $key + 1
            ]);
        }
    }
}
