<?php

    namespace App\Exports;

    use App\Models\Subscribers;
    use Maatwebsite\Excel\Concerns\FromCollection;
    use Illuminate\Contracts\View\View;
    use Maatwebsite\Excel\Concerns\FromView;

    class SubscriberExport implements FromView{

        protected $filter;

        function __construct($filter) {
            $this->filter = $filter;
        }

        public function view(): View{
            $data = [];
            $sub =  new Subscribers();
            $collections = $sub->getData($this->filter);

            if(isset($collections) && $collections->isNotEmpty()){
                $i = 0;
                $j = 1;
                foreach($collections as $row){
                    if($i == 0 || $i % 4 == 0){
                        $j++;
                        $data[$j][] = $row;
                    }else{
                        $data[$j][] = $row;
                    }
                    $i++;
                }
            }

            return view('backend.exports.subscribers', ['data' => $data]);
        }
    }
