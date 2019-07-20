<?php


namespace Blog\Infrastructure\UI\Web\Template\Php;

use Blog\Infrastructure\UI\Web\Template\TemplateRenderInterface;

class PhpRender implements TemplateRenderInterface
{
    /**
     * @var string
     */
    private $path;


    /**
     * PhpTemplateRender constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function render(string $path, array $data): string
    {
        ob_start();
        extract($data);
        include sprintf("%s/%s.php", $this->path, $path);
        $result = ob_get_clean();

        if (!$result) {
            throw new \RuntimeException("Error render view.");
        }

        return $result;
    }
}
