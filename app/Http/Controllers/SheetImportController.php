<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class SheetImportController extends Controller
{
    public function sync()
    {
        $data = [
            ["name" => "Ade Nurkholik, S.Sn", "email" => "ade.nurcholik@smkmetland.net", "password" => "Nurkholik1990"],
            ["name" => "Agustono,", "email" => "agustono300106@smkmetland.net", "password" => "Agustono1958"],
            ["name" => "Aka Hanna Gazha, M.Pd", "email" => "hanagaza25@gmail.com", "password" => "Hanna1994"],
            ["name" => "Alin Arlina, S.Pd", "email" => "alinarlina01@gmail.com", "password" => "Arlina1974"],
            ["name" => "Ani Nurdiyati, SE", "email" => "livonia83@smkmetland.net", "password" => "Nurdiyati1983"],
            ["name" => "Anisa Kurnia Sari, S.Pd", "email" => "ksanisa68@gmail.com", "password" => "KurniaSari1995"],
            ["name" => "Anthonie Feoder Malumbot, SE.Par", "email" => "malumbotfeider@gmail.com", "password" => "FeoderMalumbot1977"],
            ["name" => "Aprilliyandi Rizkia Sumirta, S.Pd", "email" => "aprilyandi.rizkia@gmail.com", "password" => "RizkiaSumirta1987"],
            ["name" => "Arief Robansyah, S.Pd", "email" => "arief@smkmetland.net", "password" => "Robansyah1978"],
            ["name" => "Asri Maharani, S.Pd", "email" => "asrimaharani02@smkmetland.net", "password" => "Maharani1992"],
            ["name" => "Atli Saputra, SS", "email" => "atlisaputra2000@gmail.com", "password" => "Saputra1981"],
            ["name" => "Christine, S.Si.,MaEd", "email" => "christinesch1771@gmail.com", "password" => "Christine1971"],
            ["name" => "Erika Yuniawati, S.Pd", "email" => "yuniawatierika@gmail.com", "password" => "Yuniawati2001"],
            ["name" => "Fainy Muchfida,", "email" => "fmuchfida@gmail.com", "password" => "Muchfida1967"],
            ["name" => "Feggy D Sukandar, A Md.Par, SE", "email" => "feggydenny@gmail.com", "password" => "DSukandar1964"],
            ["name" => "Fitriani Intan Purnamasari, S.Pd", "email" => "fitriani.hitdel@gmail.com", "password" => "IntanPurnamasari1992"],
            ["name" => "Herdianto, S.sn", "email" => "herdyuruzuke@gmail.com", "password" => "Herdianto1990"],
            ["name" => "I Gusti Agung Kuswibawa, S. Kom", "email" => "iagungk@gmail.com", "password" => "GustiAgungKuswibawa1977"],
            ["name" => "Ike Devi Alanda, S.Pd., M.Pd.", "email" => "ikedevialanda@smkmetland.net", "password" => "DeviAlanda1975"],
            ["name" => "Ikhsan Kurnia, S.Ag.", "email" => "ihksankurnia187@gmail.com", "password" => "Kurnia1998"],
            ["name" => "Indra Radjagukguk, S.E, M.M", "email" => "indraradjagukguk@gmail.com", "password" => "Radjagukguk1984"],
            ["name" => "Irgiawan Fhutuh, S.T.", "email" => "irgiawan02@gmail.com", "password" => "Fhutuh1997"],
            ["name" => "Joyce Mercy Grace Lantu, B.A. HTCM", "email" => "joylantu@smkmetland.net", "password" => "JoyceLantu25"],
            ["name" => "Khusnul Yaqin, S.Pd", "email" => "yaqinkhusnul666@gmail.com", "password" => "Yaqin1993"],
            ["name" => "Lely Irmawanti, S.Mb", "email" => "lelyirma87@gmail.com", "password" => "Irmawanti1987"],
            ["name" => "Masra Sangadji,", "email" => "sangadjimasra01@gmail.com", "password" => "@Masra123"],
            ["name" => "Meisty Andriani Rianawaty, S.Pd", "email" => "meistyandriani5@gmail.com", "password" => "AndrianiRianawaty1996"],
            ["name" => "Muhammad Alief Nurrochman, S.Li", "email" => "aliefhitoridesu@gmail.com", "password" => "AliefNurrochman2000"],
            ["name" => "Muhammad Iqbal,", "email" => "qbalnow01@gmail.com", "password" => "Iqbal2001"],
            ["name" => "Nana Suryana, M.Pd", "email" => "kangnana@smkmetland.net", "password" => "Suryana1983"],
            ["name" => "Nasrudin Djamil, S.Ag", "email" => "nasrudinsag12@gmail.com", "password" => "Djamil1970"],
            ["name" => "Ni Putu Ayu Ana Sari, S.Pd.H", "email" => "sariputu362@gmail.com", "password" => "PutuAyuAnaSari1990"],
            ["name" => "Novian Azis Efendi, S.Pd, M.Pd.", "email" => "novianazisefendi@smkmetland.net", "password" => "AzisEfendi1991"],
            ["name" => "Nuke Nurbaiti,S.Kom, M.Pd", "email" => "nuke.smkmetland@gmail.com", "password" => "Nurbaiti1972"],
            ["name" => "Ony Dina Maharani,M.Pd", "email" => "onymaharani@gmail.com", "password" => "DinaMaharani1991"],
            ["name" => "Pijar Gemilang Andhammarie, S.Pd.", "email" => "pijargemilang98@gmail.com", "password" => "GemilangAndhammarie1998"],
            ["name" => "Pirhot Fernando Simorangkir, S.Si (Teol)", "email" => "pirhotfs@gmail.com", "password" => "FernandoSimorangkir1999"],
            ["name" => "Priska Situmorang,", "email" => "priskaallianz125@gmail.com", "password" => "Situmorang1969"],
            ["name" => "Riri Nursilmi, S.Pd", "email" => "ririnursilmi25@gmail.com", "password" => "Nursilmi1996"],
            ["name" => "Riswadi, S.Kom.,M.M", "email" => "riswadi04@gmail.com", "password" => "Riswadi1978"],
            ["name" => "Rozana Adriani, SE, MM", "email" => "anaadriani07@gmail.com", "password" => "Adriani1967"],
            ["name" => "Sapta Mahendra, S.Pd.I", "email" => "saptamahendra87@gmail.com", "password" => "Mahendra1987"],
            ["name" => "Sarah Ashiyanti, S.S", "email" => "sarahyanti38@gmail.com", "password" => "Ashiyanti1972"],
            ["name" => "Suharti, SE", "email" => "hartimusyaffa@gmail.com", "password" => "Suharti1980"],
            ["name" => "Sulasminingsih, S.Pd.B", "email" => "cttsanty@gmail.com", "password" => "Sulasminingsih1989"],
            ["name" => "Susi Astiyani, A.Md.Kep", "email" => "astiyanisusi@gmail.com", "password" => "Astiyani1985"],
            ["name" => "Umi Honey, S.S.", "email" => "honeyumi37@gmail.com", "password" => "Honey1985"],
            ["name" => "Veria Raja Tunggal,", "email" => "veriarajatunggal@gmail.com", "password" => "RajaTunggal2002"],
            ["name" => "Winda Suistio Ningsih, S.S", "email" => "windasulistioningsih@gmail.com", "password" => "SuistioNingsih1993"],
            ["name" => "Yohanes Dimas Agung Nugroho, S. Pd", "email" => "yodimas90@gmail.com", "password" => "DimasAgungNugroho1990"],
            ["name" => "Yongki Saputra, S.Pd.", "email" => "a_yongki_s@yahoo.com", "password" => "Saputra1978"],
            ["name" => "Yuliana Gesti Setiawati, S.Pd", "email" => "akugesti@gmail.com", "password" => "GestiSetiawati1985"],
            ["name" => "Zhafirah Damayanti, S.Pd.", "email" => "zhadama66@gmail.com", "password" => "Damayanti1998"],
            ["name" => "Ardhani Giantnada,", "email" => "ardhanigiantnada@gmail.com", "password" => "Giantnada1986"],
            ["name" => "Hafidz Azam Bishddqi", "email" => "azambishiddqi@gmail.com", "password" => "Hazam696"],
            ["name" => "Daffa Cisco Adhyaksal ", "email" => "daffacsc@gmail.com", "password" => "Daffacsc18"],
            ["name" => "Setiyanto ", "email" => "chef.setiyanto67@gmail.com", "password" => "Setiyanto1967"]
        ];


        foreach ($data as $a => $user) {
            // dd($a + 1);

            $check_user = User::where('name', $user['name'])->count();
            if ($check_user == 0) {

                $new_user = User::create([
                    'name'      => $user['name'],
                    'email'     => $user['email'],
                    'password'  => bcrypt($user['password']),
                    'role_id'   => 3,
                    'status'    => 'Active',
                ]);

                $new_user->syncRoles([roleName(3)]);

                $new_teacher = Teacher::create([
                    'user_id'       => $new_user->id,
                ]);

                // $new_student = Student::create([
                //     'user_id'       => $new_user->id,
                //     'nis'           => $user['nis'],
                //     'classroom_id'  => 2,
                //     'expertise_id'  => $user['expertise_id'],
                //     'academic_year_id' => 3,
                //     'gender'        => $user['gender'],
                //     'religion'      => $user['religion'],
                //     'status'        => 'Student',

                // ]);
                echo $new_user->name;
            }
        }
    }

    public function urole()
    {
        $users = User::where('id', '!=', 1)->get();

        foreach ($users as $user) {
            $user->syncRoles(['Student']);
        }
    }
}
