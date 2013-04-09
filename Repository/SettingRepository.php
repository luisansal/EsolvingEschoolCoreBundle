<?php

namespace Esolving\Eschool\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SettingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SettingRepository extends EntityRepository {

    public function findOneBySettingIdByLanguage($settingId, $language) {
        $qb = $this->createQueryBuilder('setting');
        $qb->addSelect('settingType', 'settingType_languages')
                ->join('setting.settingType', 'settingType')
                ->join('settingType.languages', 'settingType_languages')
                ->where($qb->expr()->eq('setting.status', ':status'))
                ->andWhere($qb->expr()->eq('settingType_languages.language', ':language'))
                ->andWhere($qb->expr()->eq('setting.id', ':settingId'))
                ->setParameters(array(
                    'settingId' => $settingId,
                    'status' => true,
                    'language' => $language
        ));
        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }

    public function findOneByNameByLanguage($xname, $xlanguage) {
        $qb = $this->createQueryBuilder('setting');
        $q = $qb->addSelect('settingType', 'settingType_languages')
                ->join('setting.settingType', 'settingType')
                ->join('settingType.languages', 'settingType_languages')
                ->where($qb->expr()->eq('setting.status', ':status'))
                ->andWhere($qb->expr()->eq('settingType_languages.language', ':settingType_languages_language'))
                ->andWhere($qb->expr()->eq('setting.name', ':name'))
                ->setParameters(array(
                    'name' => $xname,
                    'status' => true,
                    'settingType_languages_language' => $xlanguage
                ))
                ->getQuery()
        ;
        return $q->getOneOrNullResult();
    }

    public function findAllExcept($current_setting_id) {
        $qb = $this->createQueryBuilder('setting');
        $qb = $qb
                ->where($qb->expr()->neq('setting.id', $qb->expr()->literal($current_setting_id)))
                ->getQuery()
        ;
        return $qb->getResult();
    }

    public function findAllByLanguage($xlanguage) {
        $qb = $this->createQueryBuilder('setting');
        $q = $qb->addSelect('settingType', 'settingType_languages')
                ->join('setting.settingType', 'settingType')
                ->join('settingType.languages', 'settingType_languages')
                ->where($qb->expr()->eq('settingType_languages.language', $qb->expr()->literal($xlanguage)))
                ->getQuery()
        ;
        return $q->getResult();
    }

    public function findAllByLanguageToSonataAdmin($xlanguage, $query) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query->addSelect('setting_settingType', 'setting_settingType_languages')
                ->join('o.settingType', 'setting_settingType')
                ->join('setting_settingType.languages', 'setting_settingType_languages')
                ->where($qb->expr()->eq('setting_settingType_languages.language', $qb->expr()->literal($xlanguage)))
        ;
        return $query;
    }

}
