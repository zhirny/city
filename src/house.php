<?php
    namespace zhirny\city;
    class house {
        private $street;
        public $houseNumber; //номер дома
        private $numberOfFloors; //количество этажей        
        private $numberOfPorches; //количество подъездов
        private $numberOfFlats; //число квартир
        public $areaForHouse; //площадь отведенной для дома территории
        private $cityPopulation; //число жителей города, в котором расположен дом
        public $flats = array(); //квартиры
        
        private $PaymentFromAllTeants; //размер коммунальных платежей со всех квартир
        private $volumeElectricityForLightingOfPorches; //объем потребляемого электричества для освещения подъездов
        private $LandTax; //налог на землю занимаемую домом и прилежащей к дому территорией

        const LAND_TAX_WHEN_POPULATION_OVER_1_M = 3.66; //налог на землю за 1 кв. метр в нас. пункте свыше 1 млн. жителей

        const LAND_TAX_FOR_REGIONAL_CENTERS_WHEN_POPULATION_OVER_1_M = 3; //коэффициент для городов областного значения с населением свыше 1 мл. жителей

        const ONE_LAMP_POWER = 40;
        
        const NUMBER_OF_OURS_WHERE_LIGHTING_NEED = 8;

        public function __construct($street, $houseNumber, $numberOfFloors, $numberOfPorches, $numberOfFlats, $areaForHouse, $cityPopulation, $flats) {
            $this->street = $street;
            $this->houseNumber = $houseNumber;
            $this->numberOfFloors = $numberOfFloors;
            $this->numberOfPorches = $numberOfPorches;
            $this->numberOfFlats = $numberOfFlats;
            $this->areaForHouse = $areaForHouse;
            $this->cityPopulation = $cityPopulation;
            $this->flats = $flats;
        }
       
       public function getFlat($number){
           if ($number > 0 && $number < count($this-> flats)){
               return $this->flats[$number];
           }
           return null;
       }
        public function calculatePaymentsFromAllTenants() { //размер коммунальных платежей со всех квартир в этом доме
            $sum = 0;
            for ($i=0; $i<count($this->flats); $i++) {
                $sum += $this->flats[$i]->calculatePaymentForAllUtilities();
            }
            $this->PaymentFromAllTeants = $sum;
            return $sum;
        }

        public function calculateVolumeElectricityForLightingOfPorches() { //объем потребляемого электричества для освещения подъездов в зависимости от количества подъездов и этажей
             $power = $this->numberOfPorches*$this->numberOfFloors*self::ONE_LAMP_POWER*self::NUMBER_OF_OURS_WHERE_LIGHTING_NEED/1000;
             $volumeElectricityForLightingOfPorches = $power;
            return round($power, 2);
        }

        public function calculateLandTax() { //размер налога на землю в зависимости от размера терртории, отведенной для дома
            if ($this->cityPopulation > 1000000) {$pay =  $this->areaForHouse*self::LAND_TAX_WHEN_POPULATION_OVER_1_M*self::LAND_TAX_FOR_REGIONAL_CENTERS_WHEN_POPULATION_OVER_1_M;}
            //рассчет сложный, при необходимости можно ввести другие коэффициенты для другой численности жителей, городов областного/необластного значения и курортных/некурортных зон
            $this->LandTax = round($pay, 2);
            return $this->LandTax;
        }
        

        public function showInfoAboutHouse() {
            echo "<h2>Общая информация о доме №" . $this->houseNumber . "</h2>";
            echo "<p><table><tbody>";
            echo "<tr><td>Дом находится по адресу: </td><td>" . $this->street . ", " . $this->houseNumber . "</td></tr>";
            echo "<tr><td>Количество этажей:</td><td>" . $this->numberOfFloors . "</td></tr>";
            echo "<tr><td>Количество подъездов:</td><td>" . $this->numberOfPorches . "</td></tr>";
            echo "<tr><td>Число квартир:</td><td>" . $this->numberOfFlats . "</td></tr>";
            echo "<tr><td>Площадь отведенной для дома территории :</td><td>" . $this->areaForHouse . "</td></tr>";
            echo "<tr><td>Число жителей города, в котором расположен дом:</td><td>" . round($this->cityPopulation/1000000, 3) . " млн чел.</td></tr>";
            echo "</tbody></table></p>";
        }

        public function showInfoAboutFlats() {
            echo "<h2>Информация о квартирах дома №" . $this->houseNumber . "</h2>" ;
            
            for ($i=0;$i<count($this->flats); $i++) {
                echo $this->flats[$i]->showInfoAboutFlat();
            }            
        }
        
        public function showCalculationAboutHouse() {
             echo "<h2>Рассчетные данные по дому №" . $this->houseNumber . "</h2>";
             echo "<p><table><tbody>";
             echo "<tr><td>". "Размер коммунальных платежей со всех квартир в доме:" . "</td><td>" . $this->calculatePaymentsFromAllTenants() . " грн</td></tr>";
             echo "<tr><td>". "Объем потребляемого электричества для освещения подъездов:" . "</td><td>" . $this->calculateVolumeElectricityForLightingOfPorches() . " кВт</td></tr>";
             echo "<tr><td>". "Налог на землю за террторию, отведенную для дома:" . "</td><td>" . $this->calculateLandTax() . " грн</td></tr>";
             echo"</tbody></table></p>";  

            
        }
        
        
    }
?>
