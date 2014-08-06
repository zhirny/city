<?php
    namespace zhirny\city;
    class street {
        private $streetName; //название улицы
        private $length; //протяженность
        private $streetBeginingCoordinates = array(); //коррдинаты начала улицы
        private $streetEndCoordinates = array(); //координаты конца улицы
        public $houses = array(); //дома
        
        const AREA_FOR_ONE_JANITOR = 900;
        
        public function __construct($streetName, $length, $streetBeginingCoordinates, $streetEndCoordinates, $houses) {
            $this->streetName = $streetName;
            $this->length = $length;
            $this->streetBeginingCoordinates = $streetBeginingCoordinates;
            $this->streetEndCoordinates = $streetEndCoordinates;
            $this->houses = $houses;
        }
        
        public function getStreetName(){
            return $this->streetName;
        }
        
        public function calculateAreaOfAllHouseOfTheStreet() {
            $areaTotal = 0;
            for ($i=0; $i < count($this->houses); $i++) {
                $areaTotal += $this->houses[$i]->areaForHouse;
            }
            return $areaTotal;
        }
        
        private function calculateNumberOfJanitors() {
            $numberOfJanitors =  ceil($this->calculateAreaOfAllHouseOfTheStreet()/self::AREA_FOR_ONE_JANITOR);
            return $numberOfJanitors;
        }
        
        private function calculatePaymentsFromAllHouses() {
            $sum = 0;
               for ($i=0; $i < count($this->houses); $i++) {
                $sum += $this->houses[$i]->calculatePaymentsFromAllTenants();
            }
            return $sum;
            
        }
        
        public function showStreetCalculations() {
            echo "<h2>Информация по улице " . $this->streetName  . "</h2>";
            echo "<p><table><tbody>";
            echo "<tr><td>Протяженность улицы (в километрах)</td><td>". $this->length . "</td></tr>";
            echo "<tr><td>Координаты начала улицы</td><td>";
                for ($i=0; $i < count($this->streetBeginingCoordinates); $i++) {
                    echo "&nbsp;". $this->streetBeginingCoordinates[$i] . "&nbsp;";
                }
            echo "</td></tr>";
            echo "<tr><td>Координаты конца улицы</td><td>";
                for ($i=0; $i < count($this->streetEndCoordinates); $i++) {
                    echo "&nbsp;". $this->streetEndCoordinates[$i] . "&nbsp;";
                }
            echo "</td></tr>";
            echo "<tr><td>Номер домов, расположенных на улице</td><td>";
                for ($i=0; $i < count($this->houses); $i++) {
                    echo "&nbsp;". $this->houses[$i]->houseNumber . "&nbsp;";
                }
            echo "</td></tr>";
  
            echo "<tr><td>Число дворников, необходимых для обслуживания улицы </td><td>". $this->calculateNumberOfJanitors() . "</td></tr>";
            echo "<tr><td>Сумма коммунальных платежей со всех жителей всех домов </td><td>". $this->calculatePaymentsFromAllHouses() . "</td></tr>";
            echo "</tbody></table></p>"; 
        }
    }
    
        
?>