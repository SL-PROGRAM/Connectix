<?php


namespace App\Service;


use App\Entity\Game;
use App\Entity\Product;
use App\Entity\ProductLife;
use App\Repository\ProductRepository;
use App\Repository\SeasonalityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class MakeProduct
 * @package App\Service
 */
class MakeProduct extends AbstractController
{
    /**
     * @param Game $game
     * @param ProductRepository $productRepository
     * @param SeasonalityRepository $seasonalityRepository
     */
    public function products(Game $game, ProductRepository $productRepository, SeasonalityRepository $seasonalityRepository ){
        $name = 'A';
        for($i =1; $i < 5;$i++){
            for ($j = 4; $j > 0; $j--){
                $lvl = $j;
                $productName = 'Product'.$name.$j;
                $subproductName =  'Product'.$name.($j+1);
                $subproduct = $productRepository->findOneBy(['name' => $subproductName, 'game' =>$game->getId()]);

                $this->makeProduct($seasonalityRepository,$game, $productName, $lvl, $subproduct);
            }
            $name++;
        }
    }


    /**
     * @param SeasonalityRepository $seasonalityRepository
     * @param Game $game
     * @param string $name
     * @param int $lvl
     * @param $subproduct
     */
    public function makeProduct(SeasonalityRepository $seasonalityRepository, Game $game, string $name, int $lvl, $subproduct){

            $season = $seasonalityRepository->findOneBy(['id' => 1]);
            $product = new Product();
            $row = $game->getRowMaterialCost();
            $salesPrice = $this->salesPrice($game, $lvl);
            $manPower = $this->manPowenCost($game, $lvl);
            $productionTime = $this->productionTime($game, $lvl);
            $productNumber = $this->productNumber($game, $lvl);
            $researchCost = 1000*($lvl);

            $product
                ->setGame($game)
                ->setName($name)
                ->setTechnologicLevel($lvl)
                ->setSubProduct($subproduct)
                ->setRowMaterialCost($row)
                ->setSeasonality($season)
                ->setProductionActivityCost(10)
                ->setBuyPrice(0.7*$salesPrice)
                ->setManpowerCost($manPower)
                ->setPriceDiscount(5)
                ->setProductAlreadySales(0)
                ->setProductiorTimeCost($productionTime)
                ->setProductMaxNumber($productNumber)
                ->setProductSaleType(1)
                ->setQuantityDiscount($productNumber*0.05)
                ->setResearchCost($researchCost)
                ->setSalePrice($salesPrice)
                ;

        for ($j = 1 ; $j < 5 ; $j++) {
            $cycleLife = $this-> makeCycleLife($j, $product);
            $product ->addProductLife($cycleLife);
        }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager  ->persist($product);
            $entityManager  ->flush();

    }

    /**
     * @param Game $game
     * @param $lvl
     * @return float|int
     */
    private function salesPrice(Game $game, $lvl){
        $salesPriceMin = $game->getSalesPriceMin();
        $salesPriceMax = $game->getSalesPriceMax();

        return $salesPrice = $this->addLvlPercent($salesPriceMin, $salesPriceMax, $lvl);
    }

    /**
     * @param Game $game
     * @param $lvl
     * @return float|int
     */
    private function productionTime(Game $game, $lvl){
        $productionTimeMin = $game->getProductionTimeMin();
        $productionTimeMax = $game->getProductionTimeMax();

        return $productionTime = $this->addLvlPercent($productionTimeMin, $productionTimeMax, $lvl);
    }

    /**
     * @param Game $game
     * @param $lvl
     * @return float|int
     */
    private function manPowenCost(Game $game, $lvl){
        $manPowenMin = $game->getManPowerMin();
        $manPowenMax = $game->getManPowerMax();

        return $manpower = $this->addLvlPercent($manPowenMin, $manPowenMax, $lvl);
    }

    /**
     * @param Game $game
     * @param $lvl
     * @return float|int
     */
    private function productNumber(Game $game, $lvl){
        $productNumberMin = $game->getProductNumberMin();
        $productNumberMax = $game->getProductNumberMax();

        return $productNumber = $this->addLvlPercent($productNumberMin, $productNumberMax, $lvl);

    }

    /**
     * @param $min
     * @param $max
     * @param $lvl
     * @return float|int
     */
    private function addLvlPercent($min, $max, $lvl){
        return $value = rand($min, $max)*(1+$lvl/10);
    }

    /**
     * @param $cyclelifeNumber
     * @param Product $product
     * @return ProductLife
     */
    public function makeCycleLife($cyclelifeNumber, Product $product)
    {
        $productCycle = new ProductLife();
        $cycleDuration = round(rand(1, 3));
        $publicityCoeficient = 100; // value change for calculation at the turn end
        $maxProduct = $product->getProductMaxNumber();
        $priceProduct = $product->getSalePrice();

        $entityManager = $this->getDoctrine()->getManager();
        $cycleDuration = $this->getCycleduration($product, $cyclelifeNumber, $cycleDuration);

        $productCycleMaxNumber = $maxProduct*round((rand(60, 90)/100), 2);
        $priceCoeficient = 110;
        $minPublicityImpact = $priceProduct*15;
        $maxPublicityImpact = $priceProduct*60;
        $quality = round(rand(98, 100));

        $productCycle->setCycleLifeNumber($cyclelifeNumber)
            ->setCycleDuration($cycleDuration)
            ->setProductCycleLifeNumberMax($productCycleMaxNumber)
            ->setPriceCoeficient($priceCoeficient)
            ->setPublicityCoeficient($publicityCoeficient)
            ->setPriceMinPublicityImpact($minPublicityImpact)
            ->setPriceMaxPublicityImpact($maxPublicityImpact)
            ->setQuality($quality);
        $entityManager->persist($productCycle);

        return $productCycle;
    }

    /**
     * @param Product $product
     * @param $cycleLifeNumber
     * @param $cycleDuration
     * @return int|null
     */
    public function getCycleDuration(Product $product, $cycleLifeNumber, $cycleDuration)
    {
        $cycleLifeNumber = $cycleLifeNumber-1;

        $productLifes = $product->getProductLifes();
        foreach ($productLifes as $productlife) {
            if ($cycleLifeNumber === $productlife->getCycleLifeNumber()) {
                $cycleDuration += $productlife->getCycleDuration();
            };
        }

        return $cycleDuration;
    }
}
