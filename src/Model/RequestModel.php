<?php

namespace App\Model;

use App\Entity\HostingRequest;
use App\Entity\Message;
use App\Repository\MessageRepository;

class RequestModel extends BaseModel
{
    public function getFilteredRequests($member, $folder, $sort, $sortDir, $page = 1, $limit = 10)
    {
        /** @var MessageRepository $repository */
        $repository = $this->em->getRepository(Message::class);

        return $repository->findLatestRequests($member, 'requests_'.$folder, $sort, $sortDir, $page, $limit);
    }

    public function checkRequestExpired(HostingRequest $request)
    {
        $today = (new \DateTime())->setTime(0, 0);
        $departure = $request->getDeparture();
        $departure = $departure->add(new \DateInterval('P1D'))->setTime(23, 59);

        return ($today < $departure) ? false : true;
    }
}
