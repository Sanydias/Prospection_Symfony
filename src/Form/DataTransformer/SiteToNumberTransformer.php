<?php

namespace App\Form\DataTransformer;

use App\Entity\Site;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class SiteToNumberTransformer implements DataTransformerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Transforms an object (site) to a string (number).
     *
     * @param  Site|null $site
     */
    public function transform($site): string
    {
        if (null === $site) {
            return '';
        }

        return $site->getId();
    }

    /**
     * Transforms a string (number) to an object (site).
     *
     * @param  string $siteNumber
     * @throws TransformationFailedException if object (site) is not found.
     */
    public function reverseTransform($siteNumber): ?Site
    {
        // no site number? It's optional, so that's ok
        if (!$siteNumber) {
            return null;
        }

        $site = $this->entityManager
            ->getRepository(Site::class)
            // query for the site with this id
            ->find($siteNumber)
        ;

        if (null === $site) {
            // causes a validation error
            $privateErrorMessage = sprintf('An site with number "%s" does not exist!', $siteNumber);
            $publicErrorMessage = 'The given "{{ value }}" value is not a valid site number.';

            $failure = new TransformationFailedException($privateErrorMessage);
            $failure->setInvalidMessage($publicErrorMessage, [
                '{{ value }}' => $siteNumber,
            ]);

            throw $failure;
        }

        return $site;
    }
}

