    @include('templates.header')

    <main class="px-3">
        <h1>Личный кабинет</h1>
        <p class="lead">
            В обычном случае доступ к этой странице ограничен авторизацией. Но для демонстрации здесь вы можете сфотографироваться. Данное фото будет использовано в качестве образца и использоваться
            сайтом для последующих авторизаций
        </p>

        @include('templates.auth-form')
    </main>

    @include('templates.footer')