<?php

namespace App\Console\Commands;

use App\Models\MemberLog;
use App\Models\MemberModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class KxgUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '开心购用户迁移';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sql = "select user_id,user_name,replace_coin,mobile_phone from ecs_users where platform = 2 and mobile_phone != ''";
        $users = DB::select($sql);
        DB::beginTransaction();
        try{
            foreach ($users as $user){
                $at = ceil($user->replace_coin);
                if ($at < 0) continue;
                $member['username'] = $user->user_name;
                $member['at'] = $at;
                $member['mobile'] = $user->mobile_phone;
                $member['isbind'] = 1;
                $member['mobilestatus'] = 1;
                $member['platform'] = 1;
                $member['platform_mid'] = $user->user_id;
                $res = MemberModel::create($member);
                $log['mid'] = $res->id;
                $log['value'] = $at;
                $log['msg'] = '开心购账号迁移';
                $log['time'] = time();
                $log['type'] = 'at';
                $log['admin_id'] = 0;
                $detail = ['old_at'=>0,'change_at'=>$at,'new_at'=>$at];
                $log['detail'] = json_encode($detail);
                MemberLog::create($log);
            }
            DB::commit();
            echo '迁移成功';
        }catch (QueryException $e){
            DB::rollBack();
            echo $e->getMessage() . 'AT：' . $at;
        }
    }
}
