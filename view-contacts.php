<h1>Contacts</h1>

<?foreach($contacts as $Contact){?>
    <div>
        <p class="name"><?=$Contact->surname?> <?=$Contact->name?> <?=$Contact->fname?></p>
        <p>
            <?foreach($Contact->phones as $Phone){?>
                +<?=$Phone->phone?><br>
            <?}?>
            <a class="add">Добавить телефон</a>
        </p>
        <form class="phone" method="post" action="/clerk-test-phonebook/phones/store">
            <input type="hidden" name="contactId" value="<?=$Contact->id?>">
            <input type="text"   name="phone"     placeholder="Только цифры плиз" maxlength="11"> &nbsp;
            <input type="submit" value="Добавить">
        </form>
        <p class="service">
            <a class="del" href="/clerk-test-phonebook/contacts/destroy/<?=$Contact->id?>" onClick="return confirm('Удалить контакт? Точно?! Привязанные телефоны удалятся каскадом!')">Удалить контакт</a><br>
            last updated at: <?=$Contact->updated?>
        </p>
    </div>
<?}?>



<h2>Добавить контакт</h2>

<form method="post" action="/clerk-test-phonebook/contacts/store">
    <input type="text"   name="surname"   placeholder="Фамилия">  &nbsp;
    <input type="text"   name="name"      placeholder="Имя">      &nbsp;
    <input type="text"   name="fname"     placeholder="Отчество"> &nbsp;
    <input type="submit" value="Добавить">     
</form>




<script>
    $("a.add").on('click', function(){
        $(this).parent().parent().find("form").toggle();
    });
</script>