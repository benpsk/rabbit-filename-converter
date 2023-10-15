<?php
namespace App;
use Rabbit;
class Main
{
    public function convert($directory, $to, $recursive = false)
    {
        echo date('Y-m-d H:i:s') . "\n";
        $this->renameFiles($directory, $to, $recursive);
        echo date('Y-m-d H:i:s') . "\n";
    }
    protected function renameFiles($directory, $to, $recursive)
    {
        try {
            foreach (scandir($directory) as $zgfilename) {
                if ($zgfilename == '..' || $zgfilename == '.') {
                    continue;
                }
                $zgpath = $directory . '/' . $zgfilename;
                if ($recursive && is_dir($zgpath)) {
                    $this->renameFiles($zgpath, $to, $recursive);
                }
                $unifilename = $to == 'zawgyi' ? Rabbit::uni2zg($zgfilename) : Rabbit::zg2uni($zgfilename);
                $unipath = $directory . '/' . $unifilename;
                echo "\nRenaming $zgpath to $unipath\n";
                rename($zgpath, $unipath);
            }
        } catch (\Exception $error) {
            echo "\n\nFile or Directory not found: " . $error->getMessage() . "\n\n";
        }
    }
    public function run($argv)
    {
        echo "Usage -- \n";
        echo "php converter.php <source directory> <zawgyi or unicode> <recursive=true || false>\n";
        echo "php converter.php folder unicode true\n";
        echo "php converter.php folder zawgyi true\n";
        if (isset($argv[1])) {
            $this->convert($argv[1], $argv[2], $argv[3]);
        } else {
            echo "Please provide the source directory as a command line argument.\n";
        }
    }
}
