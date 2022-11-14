<?php


class Table {

    private string $date;
    private string $reason;
    private array $causes = [];
    public function __construct(string $date, string $reason, array $causes) {
        $this->date = $date;
        $this->reason = $reason;
        $this->causes = $causes;
    }
    public function getDate(): string {
        return $this->date;
    }
    public function getReason(): string {
        return $this->reason;
    }
    public function getCauses(): array {
        return $this->causes;
    }
}
class Rows extends Table {

    public function outputDate(): string {
        return "Date: {$this->getDate()} ";
    }
    public function outputReason(): string {
        return "Reason of death: {$this->getReason()} ";
    }
    public function outputCause(): string {
//        $toString = implode(" ", $this->getCauses());
//        return "Cause of death: " . str_replace(";", "\n", $toString) . " ";
        if(empty($this->getCauses())) {
            return "Cause of death: Unknown";
        }
        return "Cause of death: " . implode(" ", $this->getCauses());
    }

}
class Board extends Rows {
    private int $rowAmount = 20;

    public function getRowAmount(): int {
        return $this->rowAmount;
    }

    public function boardInfo(): string {
        return " | " . $this->outputDate() .  " | " . $this->outputReason() . " | " . $this->outputCause() . " | ";
    }

}

$rows = [];
$row = 1;

if(($handle = fopen("dataInfo.csv", "r")) !== false) {
    while(($data = fgetcsv($handle, 1000, ",")) !== false) {
        $num = count($data);
//        echo "$num fields in line $row: " . PHP_EOL;
        $row++;
        $causes = explode(' ', $data[3]);
        $rows[] = new Table($data[1], $data[2], array_filter($causes));
        $table = new Board($data[1], $data[2], array_filter($causes));

//        echo $table->outputDate() . $table->outputReason() . $table->outputCause();
        echo $table->boardInfo() . PHP_EOL;

        if($row > $table->getRowAmount()) break;
    }
    fclose($handle);
}


