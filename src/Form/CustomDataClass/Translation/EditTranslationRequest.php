<?php

namespace App\Form\CustomDataClass\Translation;

use App\Entity\Word;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

class EditTranslationRequest
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public $wordCode;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $locale;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $englishText;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $translatedText;

    /**
     * @param Word $original
     * @param Word $translation
     *
     * @throws InvalidArgumentException
     *
     * @return EditTranslationRequest
     */
    public static function fromTranslations(Word $original, Word $translation)
    {
        if (strtolower($original->getCode()) !== strtolower($translation->getCode())) {
            throw new InvalidArgumentException();
        }

        $editTranslationRequest = new self();
        $editTranslationRequest->wordCode = $original->getCode();
        $editTranslationRequest->englishText = $original->getSentence();
        $editTranslationRequest->description = $original->getDescription();
        $editTranslationRequest->locale = $translation->getShortCode();
        $editTranslationRequest->translatedText = $translation->getSentence();

        return $editTranslationRequest;
    }
}
