<?php

    namespace App\Services;
    use PDO;

    class CurrencyService {
        private const BCV_URL = 'https://www.bcv.org.ve/'; //URL del BCV//
        private $db;

        public function __construct(PDO $db) {
            $this->db = $db;
        }

        //Obtener tasa guardada en BD//
        public function getTodayStoredRate() {
            $stmt = $this->db->prepare("SELECT rate_value FROM exchange_rates WHERE rate_date = CURDATE() LIMIT 1");
            $stmt->execute();
            return $stmt->fetchColumn();
        }

        //Escrapear tasa BCV//
        public function fetchBcvRate(): ?float {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, self::BCV_URL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

            $html = curl_exec($ch);
            curl_close($ch);

            if (!$html) return null;

            if (preg_match('/<div id="dolar".*?<strong>\s*([\d,.]+)\s*<\/strong>/s', $html, $matches)) {
                $rawRate = (float) str_replace(',', '.', trim($matches[1]));
                //Redondeo a 2 decimales por requerimiento//
                return round($rawRate, 2, PHP_ROUND_HALF_UP);
            }
            return null;
        }

        //Guardar tasa confirmada por el usuario//
        public function saveRate($rate, $userId) {
            $roundedRate = round((float)$rate, 2, PHP_ROUND_HALF_UP);
        
            $stmt = $this->db->prepare("INSERT INTO exchange_rates (rate_value, rate_date, created_by) 
                                        VALUES (?, CURDATE(), ?) 
                                        ON DUPLICATE KEY UPDATE rate_value = VALUES(rate_value)");
            return $stmt->execute([$roundedRate, $userId]);
        }
    }
?>