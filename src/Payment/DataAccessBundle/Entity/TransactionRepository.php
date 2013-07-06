<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TransactionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TransactionRepository extends EntityRepository
{
	private $recidivism = 'recidivism_cost';
	private $basisCost = 'basic_cost_water';
	private $excess = 'excess_cost'; 
	private $maxConsumption = 'maximum_consumption_milliliters'; 
	private $sewarage = 'basic_cost_sewerage'; 
	private $fineWater = 'fine_cost_water';
	private $fineWaterSewarage = 'fine_cost_water_sewerage'; 
	
	public function getItemsToCollection($user,$account,$save = false)
	{			
		$parameter = $this->getConfiguration();		
		$items = $this->getDatasToView($user,$account, $parameter,$save);
		return $items;
	}
	
	private function getItems($entity,$table,$isConsumtion)
	{
		$queryBuilder = $this->getEntityManager()->createQueryBuilder('t');
		$queryBuilder->add('select', 't');
		$queryBuilder->add('from', 'PaymentDataAccessBundle:'.$table.' t');		
		$queryBuilder->Where('t.isDeleted = 0');
		$queryBuilder->andWhere('t.isPayment = 0');
		
		if (!$isConsumtion) {
			$queryBuilder->andWhere($queryBuilder->expr()->orX(
					('t.member = ?2'),
					('t.account = ?1')));
			$queryBuilder->setParameter(2, $entity->getMember());
		} else {
			$queryBuilder->andWhere('t.account = ?1');
		}
		$queryBuilder->setParameter(1, $entity);
		$query = $queryBuilder->getQuery();
		$result = $query->getResult();
		return $result;
	}
	
	private function getConfiguration()
	{
		$queryBuilder = $this->getEntityManager()->createQueryBuilder('p');
		$queryBuilder->add('select', 'p');
		$queryBuilder->add('from', 'PaymentDataAccessBundle:Parameter p');
		$queryBuilder->Where('p.isActive = 1');	
		$query = $queryBuilder->getQuery();
		$results = $query->getResult();
		$result = array();
		foreach ($results as $item)
		{
			$result[$item->getKey()] = array('value' => $item->getValue(), 'label' => $item->getName());
		}
		return $result;
	} 
	
	private function getDatasToView($user,$account, $parameter,$save)
	{
		$items = array();
		$itemsAgregate = array();
		$consuptions = $this->getItems($account, 'Consumption', true);
		$total = 0;
		///  registro de consumo
		$consumptionsNumber = count($consuptions);
		if($consumptionsNumber > 0)
		{
			$i = 1;
			
			foreach ($consuptions as $item)
			{
				// Registro básico
				$month = array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');
				$date = $month[date('m')].' '.date('Y');
				$items[] = array('date' => $date, 'cost' => $parameter[$this->basisCost]['value'],'motive' => $parameter[$this->basisCost]['label'],'type' => 1,'amount' => 1, 'unitCost' => $parameter[$this->basisCost]['value'],'entity' => $item);
				$total = $total + $parameter[$this->basisCost]['value'];
				if ($item->getConsumptionValue() > $parameter[$this->maxConsumption]['value'])
				{
					// Registro Excedente
					$value = $item->getConsumptionValue() - $parameter[$this->maxConsumption]['value'];
					$cost = $value * $parameter[$this->excess]['value'];
					$items[] = array('date' => $date, 'cost' => $cost,'motive' => $parameter[$this->excess]['label'].' ( '.$value.'m3 x '.$parameter[$this->excess]['value'].' c/m3)','type' => 3,'amount' => $value, 'unitCost' => $parameter[$this->excess]['value'],'entity' => $item);
					$total = $total + $cost;
				}
				$fine = $parameter[$this->fineWaterSewarage]['value'];
				$fineMotive = $parameter[$this->fineWaterSewarage]['label'];
				if ($account->getSewerage())
				{
					// Registro costo de alcantarillado
					$sewerageAccount = $account->getSewerage();
					$totalSewerage = $parameter[$this->sewarage]['value'] * $sewerageAccount;
					$items[] = array('date' => $date, 'cost' => $totalSewerage,'motive' => $parameter[$this->sewarage]['label'].' ( '.$sewerageAccount.' x '.$parameter[$this->sewarage]['value'].' c/u)','type' => 2,'amount' => $sewerageAccount,'unitCost' => ($parameter[$this->sewarage]['value']),'entity' => $item);
					$total = $total + ($parameter[$this->sewarage]['value'] * $sewerageAccount);
					$fine = $parameter[$this->fineWater]['value'];
					$fineMotive = $parameter[$this->fineWater]['label'];
				}
				
				if($i < $consumptionsNumber)
				{
					$items[] = array('date' => $date, 'cost' => $fine,'motive' => $fineMotive,'type' => 6,'amount' => 1,'unitCost' => $fine,'entity' => $item);
					$total = $total + ($fine);	
					$i++;
				}
			}

		} 
		else 
		{
			return null;
		}
		
		$payments = $this->getItems($account, 'Payment', false);
		$cont = array();
		$type = 0;
		foreach ($payments as $item)
		{
			$motive =  $item->getPaymentType()->getName();
			$items[] = array('date' => $item->getPaymentDate()->format('Y-m-d'), 'cost' => $item->getCost(),'motive' => $motive,'type' => 4,'amount' => 1,'unitCost' => $item->getCost(), 'entity' => $item);
			$total = $total + $item->getCost();
			
			if($item->getIsRecidivism())
			{
				$items[] = array('date' => $item->getPaymentDate()->format('Y-m-d'), 'cost' => $parameter[$this->recidivism]['value'],'motive' => $parameter[$this->recidivism]['label'].' '.$motive,'type' => 5,'amount' => 1,'unitCost' => $parameter[$this->recidivism]['value'], 'entity' => $item);
				$total = $total + $parameter[$this->recidivism]['value'];
			}			
		}

		if ($save)
		{
			$result['transaction'] = $this->saveItems($user,$payments,$consuptions,$items, $total);
		}
		$result['items'] = $items;
		return $result;			
	}
	
	private function saveItems($user,$payments,$consumptions,$items,$total)
	{
		$em = $this->getEntityManager();
		$em->getConnection()->beginTransaction();
		try 
		{		
			$managerial = $em->getRepository('PaymentDataAccessBundle:Managerial')->findOneBy(array('isActive' => 1),array('id' => 'DESC'));
			$userData = $em->getRepository('PaymentDataAccessBundle:SystemUser')->find($user->getId());
			$transactionType = $em->getRepository('PaymentDataAccessBundle:TransactionType')->find(1);
			$transaction = new Transaction();
			$transaction->setTotalValue($total);
			$transaction->setSystemDate(new \DateTime());
			$transaction->setManagerial($managerial);
			$transaction->setSystemUser($userData);
			$transaction->setTransactionType($transactionType);
			$em->persist($transaction);
			$em->flush();
			
			foreach ($items as $item)
			{
				$type = $em->getRepository('PaymentDataAccessBundle:IncomeType')->find($item['type']);
				$income = new Income();
				$income->setIncomeType($type);
				$income->setTransaction($transaction);
				if (($item['type']== 4)||($item['type']== 5))
				{
					$income->setPayment($item['entity']);
				} else {
					$income->setConsumption($item['entity']);
				}				
				$income->setSystemUser($userData);
				$income->setAmount($item['amount']);
				$income->setBasicServiceUnitCost($item['unitCost']);
				$em->persist($income);
				$em->flush();
							
			}
			// Marcacion de pagos Cancelados
			foreach ($consumptions as $item)
			{
				$item->setIsPayment(1);
				$em->persist($item);
				$em->flush();
			}
			foreach ($payments as $item)
			{		
				$item->setIsPayment(1);
				$em->persist($item);
				$em->flush();
			}
		$em->getConnection()->commit();
		
		} catch (Exception $e) {
			$em->getConnection()->rollback();
			$em->close();
			throw $e->getMessage();
		}
		return $transaction->getId();
	}	
	
	public function findCollectionByFilters($controller, $startDate,$endDate, $offset, $limit, $count = true)
	{
		$conec = $controller->get("database_connection");
		
		if ($count == true)
		{
			$sql = "SELECT count(distinct(`transaction`.id)) as total";
			$lim = "";			
		}
		else
		{
			$sql = "SELECT distinct(`transaction`.id), account.account_number as accountNumber, member.name, member.lastname, `transaction`.total_value as totalValue, `transaction`.system_date as systemDate";
			$lim =  " limit ". $offset.",".$limit;			
		}
		
		$sql.= " FROM `transaction` inner join income 
				on income.transaction_id = `transaction`.id
				inner join consumption
				on consumption.id = income.consumption_id
				inner join account
				on account.id = consumption.account_id
				inner join member
				on member.id = account.member_id";
		if($startDate)
		{
			$sql.= " where ('".$startDate."' <= `transaction`.system_date)";			
		}
		if($endDate)
		{
			if ($startDate)
			{
				$val = ' and ';
			}			
			else
			{
				$val = ' where ';
			}
			$sql.= $val." ('".$endDate."' >= `transaction`.system_date)";
		}
		$sql.= " order by (`transaction`.id)".$lim;
		$result =  $conec->fetchAll($sql);		
		return $result;
	}	
}