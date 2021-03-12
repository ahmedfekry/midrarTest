<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Storage;

class TestingReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:test {order=asc}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generates a report of the users testing results';

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
        $data = DB::select('select accounts.account_username as User_name,COUNT(tests.test_id) as number_of_tests 
        from accounts JOIN tests on accounts.account_id = tests.test_account_id GROUP BY accounts.account_username 
        ORDER BY COUNT(tests.test_id) '.$this->argument('order'));
        $result = array(array('User_name', 'Number of tests'));
        foreach($data as $record){
            $temp = array($record->User_name,$record->number_of_tests);
            array_push($result,$temp);
        }
        if(Storage::disk('reports')->has('report.json'))
        {
            Storage::disk('reports')->delete(['report.json']);
        }
        $content = "var docDefinition = {
            content: [
                {text: 'Testing Result', style: 'header'},
                {
                    style: 'tableExample',
                    table: {
                        body: ".json_encode($result)."
                    }
                },
            ],
            styles: {
                header: {
                    fontSize: 18,
                    bold: true,
                    margin: [0, 0, 0, 10]
                },
                tableExample: {
                    margin: [0, 5, 0, 15]
                },
                tableHeader: {
                    bold: true,
                    fontSize: 13,
                    color: 'black'
                }
            },
            defaultStyle: {
                // alignment: 'justify'
            }
        };
        pdfMake.createPdf(docDefinition).download();";

        Storage::disk('reports')->put('report.js', $content);
    }
}
