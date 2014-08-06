<?php
    namespace zhirny\city;
    class flat {
        private $number; //номер квартиры
        private $area;  //площадь квартиры
        private $numberOfTenants; //количество жильцов
        private $electricityConsumption; //расход электроэнергии
        private $gasConsumption; //расход газа
        private $coldWaterConsumption; //расход холодной воды
        private $hotWaterConsumption; //расход горячей воды
        private $floor; //этаж
        private $numberOfRooms; //количество комнат
        private $numberOfBalconies; // количество балконов
        private $typeOfHeating; //тип отопления
        
        
        const PAYMENT_FOR_ELECTRICITY_UP_TO_150KW = 0.3084; //за 1 кВт/ч при расходе до 150кват в месяц
        const PAYMENT_FOR_ELECTRICITY_BETWEEN_150_AND_800KW = 0.4194; //за 1 кВт/ч при расходе от 150кват до 800кВт/ч в месяц
        const PAYMENT_FOR_ELECTRICITY_OVER_800KW = 1.3404; //за 1 кВт/ч при расходе свыше 800кВт/ч в месяц
        const PAYMENT_FOR_GAS_WITH_COUNTER = 1.182; // за 1 кубометр, если есть счетчик
        const PAYMENT_FOR_GAS_WITHOUT_COUNTER = 1.299; // за 1 кубометр, если нет счетчика
        const PAYMENT_FOR_AREA =  3.18; //за 1 кв. метр
        const PAYMENT_FOR_COLD_WATER = 4.15; //холодная вода + водоотведение за 1 кубометр
        const PAYMENT_FOR_HOT_WATER = 13.78; //горячая вода за 1 кубометр
        const PAYMENT_FOR_HEATING = 9.58; //отопление отопительный сезон (оплата только в отопительный сезон)
        
        public function getNumberOfTenants() {
            return $this->numberOfTenants;
        }
        
        public function __construct($area, $numberOfTenants, $electricityConsumption,  $gasConsumption, $coldWaterConsumption, $hotWaterConsumption, $floor, $numberOfRooms, $numberOfBalconies, $typeOfHeating, $number) {
            $this->number = $number;
            $this->area = $area;
            $this->numberOfTenants = $numberOfTenants;
            $this->electricityConsumption = $electricityConsumption;
            $this->gasConsumption = $gasConsumption;
            $this->coldWaterConsumption = $coldWaterConsumption; 
            $this->hotWaterConsumption = $hotWaterConsumption;
            $this->floor = $floor;
            $this->numberOfRooms = $numberOfRooms;
            $this->numberOfBalconies = $numberOfBalconies;
            $this->typeOfHeating = $typeOfHeating;
        }
        
        private function calculatePaymentForElectricity() {
            if ($this->electricityConsumption < 150) {$pay = $this->electricityConsumption*self::PAYMENT_FOR_ELECTRICITY_UP_TO_150KW;}
                else {
                    if ($this->electricityConsumption >= 150 AND $this->electricityConsumption <800 ) {$pay = $this->electricityConsumption*self::PAYMENT_FOR_ELECTRICITY_BETWEEN_150_AND_800KW;}
                        else $pay = $this->electricityConsumption*self::PAYMENT_FOR_ELECTRICITY_OVER_800KW;}
            return round($pay, 2);
        }
        
        private function calculatePaymentForGas() {
            $pay =  $this->gasConsumption*self::PAYMENT_FOR_GAS_WITH_COUNTER;
            return round($pay, 2);
        }
        
        private function calculatePaymentForColdWater() {
            $pay =  $this->coldWaterConsumption * self::PAYMENT_FOR_COLD_WATER;
            return round($pay, 2);
        }
        
        private function calculatePaymentForHotWater() {
            $pay =  $this->hotWaterConsumption * self::PAYMENT_FOR_HOT_WATER;
            return round($pay, 2);
        }
        
        private function calculatePaymentForHeating() {
            $pay = $this->area*self::PAYMENT_FOR_HEATING;
            return round($pay, 2);
        }
        
        private function calculateRent() {
            $pay = $this->area*self::PAYMENT_FOR_AREA;
            return round($pay, 2);
        }
        
        public function calculatePaymentForAllUtilities() {
            $pay =  $this->calculatePaymentForElectricity() + $this->calculatePaymentForGas() +   $this->calculatePaymentForColdWater() + $this->calculatePaymentForHotWater() +  $this->calculatePaymentForHeating() + $this->calculateRent();
            return round($pay, 2);
        }
        
        public function showPayForAllDetailed() {
            echo "<hr><h3>Информация по квартплате</h3>";
            echo "<p><table><tbody>";
            echo "<tr><td>Электричество:</td><td>" . $this->calculatePaymentForElectricity() . "</td></tr>";
            echo "<tr><td>Газ:</td><td>" . $this->calculatePaymentForGas() . "</td></tr>";
            echo "<tr><td>Холодная вода:</td><td>" . $this->calculatePaymentForColdWater() . "</td></tr>";
            echo "<tr><td>Горячая вода:</td><td>" . $this->calculatePaymentForHotWater() . "</td></tr>";
            echo "<tr><td>Отопление:</td><td>" . $this->calculatePaymentForHeating() . "</td></tr>";
            echo "<tr><td>Жилплощадь:</td><td>" . $this->calculateRent() . "</td></tr>";
            echo "<tr><td>Итого за все коммунальные услуги:</td><td>" . $this->calculatePaymentForAllUtilities() . "</td></tr>";
            echo "</tbody></table></p>";
            
            
        }

        public function showInfoAboutFlat() {
            echo "<h3>Информация о квартире №" . $this->number . "</h3>";
            echo "<p><table><tbody>";
            echo "<tr><td>Площадь квартиры:</td><td>" . $this->area . "</td></tr>";
            echo "<tr><td>Количество жильцов:</td><td>" . $this->numberOfTenants . "</td></tr>";
            echo "<tr><td>Расход электроэнергии:</td><td>" . $this->electricityConsumption . "</td></tr>";
            echo "<tr><td>Расход газа:</td><td>" . $this->gasConsumption . "</td></tr>";
            echo "<tr><td>Расход холодной воды:</td><td>" . $this->coldWaterConsumption . "</td></tr>";
            echo "<tr><td>Расход горячей воды:</td><td>" . $this->hotWaterConsumption . "</td></tr>";
            echo "<tr><td>Этаж:</td><td>". $this->floor . "</td></tr>";
            echo "<tr><td>Количество комнат:</td><td>" . $this->numberOfRooms . "</td></tr>";
            echo "<tr><td>Количество балконов:</td><td>" . $this->numberOfBalconies . "</td></tr>";
            echo "<tr><td>Тип отопления:</td><td>" . $this->typeOfHeating . "<br>";
            echo "</tbody></table></p>";
            
        }
        
        public function addTenants($n) {
            $count = $this->numberOfTenants + $n;
            return $count;
        }
        
        public function removeTenants($n) {
            if ($this->numberOfTenants > $n) {$count = $this->numberOfTenants - $n;}
            else exit;
        }
    }
?>