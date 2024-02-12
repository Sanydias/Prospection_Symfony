<?php

namespace App\Form\DataTransformer;

use App\Entity\Site;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class SiteToStringTransformer implements DataTransformerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Transforms an object (site) to a string (string).
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
     * Transforms a string (string) to an object (site).
     *
     * @param  string $siteString
     * @throws TransformationFailedException if object (site) is not found.
     */
    public function reverseTransform($siteString): ?Site
    {
        // no site string? It's optional, so that's ok
        if (!$siteString) {
            return null;
        }

        $site = $this->entityManager
            ->getRepository(Site::class)
            // query for the site with this id
            ->find($siteString)
        ;

        if (null === $site) {
            // causes a validation error
            $privateErrorMessage = sprintf('An site with string "%s" does not exist!', $siteString);
            $publicErrorMessage = 'The given "{{ value }}" value is not a valid site string.';

            $failure = new TransformationFailedException($privateErrorMessage);
            $failure->setInvalidMessage($publicErrorMessage, [
                '{{ value }}' => $siteString,
            ]);

            throw $failure;
        }

        return $site;
    }
}

