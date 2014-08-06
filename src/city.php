<?php
    namespace zhirny\city;
    class city {
        private $cityName; //название города
        private $yearOfFoundation; //год основания
        private $coordinatesOfCity = array(); //географические координаты
        private $streets = array();

        const MAGIC_CONSTANT_FOR_CALCULATE_BUDGET_OF_CITY = 12.839; 

        public function __construct($cityName, $yearOfFoundation, $coordinatesOfCity, $streets) {
            $this->cityName = $cityName;
            $this->yearOfFoundation = $yearOfFoundation;
            $this->coordinatesOfCity = $coordinatesOfCity;
            $this->streets = $streets;
        }

        // рассчитывает бюджет населенного пункта в зависимости от размера налога на землю, полученного со всех домов;
        public function calculateOfBudgetOfCity() {
//            debugbreak();
            $landTaxTotal = 0;
            //echo count($this->streets[0]->houses) . "<br><br><br><br><br><br><br>";
            for ($i=0; $i < count($this->streets); $i++) {
                for  ($j=0; $j < count($this->streets[$i]->houses); $j++) { 
                    $landTaxTotal += $this->streets[$i]->houses[$j]->calculateLandTax();
                }
            }
            $budget = $landTaxTotal*self::MAGIC_CONSTANT_FOR_CALCULATE_BUDGET_OF_CITY;
            return $budget;
        }
        // рассчитывает количество населения, проживающего в населенном пункте;
        
        private function calculatePopulation() {
            $population = 0;
            for ($i=0; $i < count($this->streets); $i++) {
                for  ($j=0; $j < count($this->streets[$i]->houses); $j++) { 
                    for ($k=0; $k < count ($this->streets[$i]->houses[$j]->flats); $k++) {
                        $population += $this->streets[$i]->houses[$j]->flats[$k]->getNumberOfTenants();
                    }
                }
            }
            return $population;
        }

        // выводит информацию о населенном пункте.    
        public function showInfoAboutCity() {
            echo "<h2>Информация о городе " . $this->cityName  . "</h2>";
            echo "<p><table><tbody>";
            echo "<tr><td>Год основания</td><td>". $this->yearOfFoundation . "</td></tr>";
            echo "<tr><td>Географические координаты</td><td>";
            for ($i=0; $i < count($this->coordinatesOfCity); $i++) {
                echo "&nbsp;". $this->coordinatesOfCity[$i] . "&nbsp;";
            }
            echo "</td></tr>";
            echo "<tr><td>Улицы города</td><td>";
            for ($i=0; $i < count($this->streets); $i++) {
                echo "&nbsp;". $this->streets[$i]->getStreetName($i) . "&nbsp;";
            }
            echo "</td></tr>";

            echo "<tr><td>Бюджет города</td><td>". $this->calculateOfBudgetOfCity() . "</td></tr>";
            echo "<tr><td>Население города</td><td>". $this->calculatePopulation() . "</td></tr>";
            echo "</tbody></table></p>"; 
        }
    }
?>