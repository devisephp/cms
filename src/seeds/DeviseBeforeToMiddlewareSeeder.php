<?php

class DeviseBeforeToMiddlewareSeeder extends DeviseSeeder
{
    /**
     * [run description]
     * @return [type]
     */
    public function run()
    {
        // only going to changes values that are in this array
        $deviseRules =  $this->getAllPermissionNames();

        $pagesWithMiddleWare = DB::table('dvs_pages')->where('middleware','<>','')->get();

        foreach ($pagesWithMiddleWare as $page) {
            $parts = explode('|', $page->middleware);
            foreach ($parts as &$part) {
                // if it matches a rule in config then it needs the middleware name
                if(in_array($part, $deviseRules)) {
                    $part = 'devise.permissions:' . $part;
                }
            }
            
            $newValue = implode('|', $parts);
            
            DB::table('dvs_pages')->where('id',$page->id)->update(['middleware'=>$newValue]);
        }
    }

    private function getAllPermissionNames()
    {
        $permissions = config('devise.permissions');
        return array_keys($permissions);
    }

}