### EndPoints
- [GET] `/get-articles` - Retorna articulos paginados.
    - **Params**
        - `search`: Busca los articulos por nombre o cuyo nombre contenga el valor del parametro
        - `per_page`: Indica la cantidad de items por pagina - Defecto: 12
        - `page`: Indica el numero de la pagina a consultar - Defecto: 1
- [GET] `/get-article/{id}` - Retorna un articulo en especifico.
