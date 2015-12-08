<?php

namespace Utilities\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Nelmio\Alice\Loader\Yaml;

/**
 * A command that uses the Alice data-generator to generate testing data 
 * 
 * Run using:
 * bin/cli schema:data-generate
 *
 * 
 * Note : please make use there is no 'CS Departement' in the department 
 * database table, so as not to violate any constrains
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @package utilities
 * @subpackage console
 */
class DataGenerator extends Command
{

    /**
     * Configure command properties
     * {@inheritdoc}
     * @access protected
     */
    protected function configure()
    {
        $this
                ->setName('schema:data-generate')
                ->setDescription('Use Alice to generate testing data')
                ->setHelp(<<<EOT
This command create 10 users , 1 branche , 1 postion , 1 department
EOT
        );
    }

    /**
     * Load fixtures in database
     * {@inheritdoc}
     * 
     * @uses Yaml
     * @access protected
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        date_default_timezone_set("UTC");
        /* @var $entityManager \Doctrine\ORM\EntityManager */
        $entityManager = $this->getHelper('em')->getEntityManager();

        $loader = new Yaml();

        $branches = $loader->load('data/fixtures/BranchFixtures.yml');
        $this->insertObjectsInDatabase($entityManager, $branches);

        $positions = $loader->load('data/fixtures/PositionFixtures.yml');
        $this->insertObjectsInDatabase($entityManager, $positions);

        $vacations = $loader->load('data/fixtures/VacationFixtures.yml');
        $this->insertObjectsInDatabase($entityManager, $vacations);
        
        $attendance = $loader->load('data/fixtures/AttendanceFixtures.yml');
        foreach ($attendance as $key) {
            $key->startTime = new \DateTime("now");
            $key->endTime = new \DateTime("now");
        }
        $this->insertObjectsInDatabase($entityManager, $attendance);

        $departments = $loader->load('data/fixtures/DepartmentFixtures.yml');
        $this->insertObjectsInDatabase($entityManager, $departments);

        $users = $loader->load('data/fixtures/UserFixtures.yml');
        // append a date object for every user object
        foreach ($users as $object) {
            if (isset($object->password))
                $object->password = \Users\Entity\User::hashPassword($object->password);
            $object->manager = $users['user26'];
            $object->dateOfBirth = new \DateTime("now");
            $object->startDate = new \DateTime("now");
            $object->branch = $branches['branch1']; //$repository->find(1);
            $object->position = $positions['position1'];
            $object->department = $departments['department1'];
        }
        $this->insertObjectsInDatabase($entityManager, $users);

        $holidays = $loader->load('data/fixtures/HolidayFixtures.yml');
        // append a date object for every user object
        foreach ($holidays as $object) {
            $randomDate = new \DateTime($object->dateFrom);
            $object->dateFrom = clone $randomDate;
            $randomDate1 = new \DateTime($object->dateTo);
            $object->dateTo = clone $randomDate1;
        }
        $this->insertObjectsInDatabase($entityManager, $holidays);

        $permissions = $loader->load('data/fixtures/PermissionFixtures.yml');
        foreach ($permissions as $key) {
            $key->user = $users['user23'];
            $key->date = new \DateTime($key->date);
            $key->fromTime = new \DateTime($key->fromTime);
            $key->toTime = clone $key->fromTime;
            $key->toTime->modify('+' . rand(1, 8) . ' hour');
            $key->dateOfSubmission = new \DateTime($key->dateOfSubmission);
        }
        $this->insertObjectsInDatabase($entityManager, $permissions);

        $attendanceRecords = $loader->load('data/fixtures/AttendanceRecordFixtures.yml');

        foreach ($attendanceRecords as $key) {
            $key->branch = $branches['branch1'];
            $key->user = $users['user26'];
            $key->timeOut = clone $key->timeIn;
            $key->timeOut->modify('+' . rand(1, 8) . ' hour');
        }

        $this->insertObjectsInDatabase($entityManager, $attendanceRecords);

        $workFromHome = $loader->load('data/fixtures/WorkFromHomeFixtures.yml');
        foreach ($workFromHome as $key) {
            $key->startDate = new \DateTime("now");
            $key->endDate = new \DateTime("now");
            $key->dateOfSubmission = new \DateTime('now');
        }
        $this->insertObjectsInDatabase($entityManager, $workFromHome);
        
        $vacationRequests = $loader->load('data/fixtures/VacationRequestFixtures.yml');
        $this->insertObjectsInDatabase($entityManager, $vacationRequests);
        
        $comments = $loader->load('data/fixtures/CommentFixtures.yml');

        foreach ($comments as $key) {
            $key->branch = $branches['branch1'];
            $key->user = $users['user' . $key->user];
            $key->created = new \DateTime($key->created);
        }

        $this->insertObjectsInDatabase($entityManager, $comments);
        
        $notification = $loader->load('data/fixtures/NotificationFixtures.yml');
        $this->insertObjectsInDatabase($entityManager, $notification); 
        
        $entityManager->flush();

        $output->writeln('Data Added');
    }

    /**
     * Persist objects in database
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access private
     * @param Doctrine\Common\Persistence\ObjectManager $entityManager
     * @param array $objectsToInsert
     */
    private function insertObjectsInDatabase($entityManager, $objectsToInsert)
    {
        foreach ($objectsToInsert as $object) {
            $entityManager->persist($object);
        }
    }

}
