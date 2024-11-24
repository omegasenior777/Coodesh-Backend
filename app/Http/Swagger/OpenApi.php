<?php

/**
 * @OA\Info(
 *     title="Dictionary API",
 *     version="1.0.0",
 *     description="API para gerenciar um dicionário com funcionalidades de autenticação, favoritos e histórico.",
 *     @OA\Contact(
 *         email="support@dictionaryapi.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url="/",
 *     description="Servidor Local"
 * )
 */

/**
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Autenticação via token JWT. Insira 'Bearer <seu_token>' no cabeçalho Authorization."
 * )
 */

/**
 * @OA\Get(
 *     path="/",
 *     summary="Retorna a mensagem: Fullstack Challenge 🏅 - Dictionary",
 *
 *
 *     @OA\Response(
 *          response=200,
 *          description="Mensagem retornada com sucesso",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string", example="Fullstack Challenge 🏅 - Dictionary")
 *          )
 *      ),
 *     @OA\Response(
 *            response=204,
 *            description="sucesso sem body",
 *        ),
 *       @OA\Response(
 *           response=400,
 *           description="Nenhuma entrada encontrada",
 *       @OA\JsonContent(
 *                type="object",
 *                @OA\Property(property="message", type="string", example="Error message")
 *            )
 *       ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro interno do servidor"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/user/me",
 *     summary="Retorna o perfil usuário",
 *     tags={"User"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Perfil retornado com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *           response=204,
 *           description="sucesso sem body",
 *       ),
 *      @OA\Response(
 *          response=400,
 *          description="Nenhuma entrada encontrada",
 *      @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="message", type="string", example="Error message")
 *           )
 *      ),
 *     @OA\Response(
 *         response=401,
 *         description="Usuário não autenticado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro interno do servidor"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/user/me/history",
 *     summary="Retorna o histórico de palavras visualizadas pelo usuário",
 *     tags={"User"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Histórico de palavras visualizadas retornado com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="results", type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="word", type="string", example="fire"),
 *                     @OA\Property(property="added", type="string", format="date-time", example="2022-05-05T19:28:13.531Z")
 *                 )
 *             ),
 *             @OA\Property(property="totalDocs", type="integer", example=20),
 *             @OA\Property(property="page", type="integer", example=2),
 *             @OA\Property(property="totalPages", type="integer", example=5),
 *             @OA\Property(property="hasNext", type="boolean", example=true),
 *             @OA\Property(property="hasPrev", type="boolean", example=true)
 *         )
 *     ),
 *     @OA\Response(
 *           response=204,
 *           description="sucesso sem body",
 *       ),
 *      @OA\Response(
 *          response=400,
 *          description="Nenhuma entrada encontrada",
 *      @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="message", type="string", example="Error message")
 *           )
 *      ),
 *     @OA\Response(
 *         response=401,
 *         description="Usuário não autenticado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro interno do servidor"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/user/me/favorites",
 *     summary="Retorna as palavras favoritadas pelo usuário",
 *     tags={"User"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Palavras favoritadas retornado com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="results", type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="word", type="string", example="fire"),
 *                     @OA\Property(property="added", type="string", format="date-time", example="2022-05-05T19:28:13.531Z")
 *                 )
 *             ),
 *             @OA\Property(property="totalDocs", type="integer", example=20),
 *             @OA\Property(property="page", type="integer", example=2),
 *             @OA\Property(property="totalPages", type="integer", example=5),
 *             @OA\Property(property="hasNext", type="boolean", example=true),
 *             @OA\Property(property="hasPrev", type="boolean", example=true)
 *         )
 *     ),
 *     @OA\Response(
 *           response=204,
 *           description="sucesso sem body",
 *       ),
 *      @OA\Response(
 *          response=400,
 *          description="Nenhuma entrada encontrada",
 *      @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="message", type="string", example="Error message")
 *           )
 *      ),
 *     @OA\Response(
 *         response=401,
 *         description="Usuário não autenticado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro interno do servidor"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/entries/en",
 *     summary="Lista todas as entradas no dicionário",
 *     tags={"Dictionary"},
 *     @OA\Parameter(
 *          name="search",
 *          in="query",
 *          required=false,
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\Parameter(
 *          name="limit",
 *          in="query",
 *          required=false,
 *          @OA\Schema(type="integer", default=10)
 *      ),
 *     @OA\Response(
 *          response=200,
 *          description="Lista de entradas retornada com sucesso",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="results", type="array", @OA\Items(type="string")),
 *              @OA\Property(property="totalDocs", type="integer"),
 *              @OA\Property(property="page", type="integer"),
 *              @OA\Property(property="totalPages", type="integer"),
 *              @OA\Property(property="hasNext", type="boolean"),
 *              @OA\Property(property="hasPrev", type="boolean")
 *          )
 *      ),
 *     @OA\Response(
 *           response=204,
 *           description="sucesso sem body",
 *       ),
 *      @OA\Response(
 *          response=400,
 *          description="Nenhuma entrada encontrada",
 *      @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="message", type="string", example="Error message")
 *           )
 *      ),
 *     @OA\Response(
 *         response=404,
 *         description="Palavra não encontrada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Word not found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro interno do servidor"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/entries/en/{word}",
 *     summary="Exibe o detalhe de uma palavra no dicionário",
 *     tags={"Dictionary"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *           name="word",
 *           in="path",
 *          required=true,
 *          @OA\Schema(type="string"),
 *          description="A palavra exata a ser buscada no dicionário"
 *       ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de entradas retornada com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="results", type="array", @OA\Items(type="string")),
 *             @OA\Property(property="totalDocs", type="integer"),
 *             @OA\Property(property="page", type="integer"),
 *             @OA\Property(property="totalPages", type="integer"),
 *             @OA\Property(property="hasNext", type="boolean"),
 *             @OA\Property(property="hasPrev", type="boolean")
 *         )
 *     ),
 *     @OA\Response(
 *          response=204,
 *          description="sucesso sem body",
 *      ),
 *     @OA\Response(
 *         response=400,
 *         description="Nenhuma entrada encontrada",
 *     @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string", example="Error message")
 *          )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro interno do servidor"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/entries/en/{word}/favorite",
 *     summary="Favoritar uma palavra",
 *     tags={"Dictionary"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *           name="word",
 *           in="path",
 *          required=true,
 *          @OA\Schema(type="string"),
 *          description="A palavra exata a ser buscada no dicionário"
 *       ),
 *     @OA\Response(
 *         response=200,
 *         description="Palavra favoritada com sucesso",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string", example="Palavra favoritada com sucesso"),
 *              @OA\Property(property="word", type="string", example="fire")
 *         )
 *     ),
 *     @OA\Response(
 *          response=204,
 *          description="sucesso sem body",
 *      ),
 *     @OA\Response(
 *         response=400,
 *         description="Nenhuma entrada encontrada",
 *     @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string", example="Error message")
 *          )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro interno do servidor"
 *     )
 * )
 */

/**
 * @OA\Delete(
 *     path="/entries/en/{word}/unfavorite",
 *     summary="Desfavoritar uma palavra",
 *     tags={"Dictionary"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *           name="word",
 *           in="path",
 *          required=true,
 *          @OA\Schema(type="string"),
 *          description="A palavra exata a ser desfavoritada no dicionário",
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Palavra desfavoritada com sucesso",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string", example="Palavra desfavoritada com sucesso"),
 *              @OA\Property(property="word", type="string", example="fire")
 *          )
 *     ),
 *     @OA\Response(
 *          response=204,
 *          description="sucesso sem body",
 *      ),
 *     @OA\Response(
 *         response=400,
 *         description="Nenhuma entrada encontrada",
 *     @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string", example="Error message")
 *          )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro interno do servidor"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/auth/signup",
 *     summary="Registra um novo usuário",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "password"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="secretpassword")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Usuário registrado com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="token", type="string", example="Bearer token_example")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Erro na validação de dados",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Error message")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro interno do servidor"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/auth/signin",
 *     summary="Autentica um usuário",
 *     tags={"Auth"},
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="secretpassword")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuário autenticado com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="token", type="string", example="Bearer token_example")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Credenciais inválidas",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Invalid credentials")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro interno do servidor"
 *     )
 * )
 */


/**
 * @OA\Post(
 *     path="/auth/logout",
 *     summary="Desloga o usuário autenticado",
 *     tags={"Auth"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Usuário deslogado com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Logged out successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Não autorizado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Unauthorized")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro interno do servidor"
 *     )
 * )
 */
