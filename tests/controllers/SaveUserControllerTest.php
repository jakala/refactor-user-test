<?php
    declare(strict_types=1);

    namespace TechnicalTest\Tests\src\Controller;

    use PHPUnit\Framework\TestCase;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use TechnicalTest\backend\controllers\SaveUserController;
    use TechnicalTest\Infrastructure\MysqlUserRepository;

    final class SaveUserControllerTest extends TestCase
    {
        public function setUp(): void
        {
            (new MysqlUserRepository())->emptyUsers();
        }

        /**
         * @test
         */
        public function create_a_new_user(): void
        {
            $request = $this->getCreateUserRequest();
            $response = $this->getResponse();
            $array['id'] = 'new_id';

            $controller = $this->getController();
            $result = $controller->add($request, $response, $array);

            $this->assertEquals(201, $result->getStatusCode());
        }

        /**
         * @test
         */
        public function update_an_existence_user(): void
        {
            $this->create_a_new_user();
            $request = $this->getUpdateUserRequest();
            $response = $this->getResponse();
            $array['id'] = 'new_id';

            $controller = $this->getController();
            $result = $controller->add($request, $response, $array);

            $this->assertEquals(201, $result->getStatusCode());


        }

        private function getCreateUserRequest(): ServerRequestInterface
        {
            $request = $this->createMock(ServerRequestInterface::class);
            $request
                ->method('getBody')
                ->willReturn('{"name": "new_user", "phone": "655000000"}');

            return $request;
        }

        private function getUpdateUserRequest(): ServerRequestInterface
        {
            $request = $this->createMock(ServerRequestInterface::class);
            $request
                ->method('getBody')
                ->willReturn('{"name": "updated_name", "phone": "999000000"}');

            return $request;
        }


        private function getResponse(): ResponseInterface
        {
            $response = $this->createMock(ResponseInterface::class);

            $response
                ->method('getStatusCode')
                ->willReturn(201);
            $response
                ->method('withStatus')
                ->willReturn($response);

            return $response;
        }

        private function getController(): SaveUserController
        {
            return new SaveUserController();
        }
    }