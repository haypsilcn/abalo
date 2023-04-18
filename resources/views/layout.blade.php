<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Scripts -->
    <script src="{{ asset('js/cookiecheck.js') }}" defer></script>

    <meta charset="UTF-8">
    <title></title>
</head>
<body>

<div id="cookieNotice" style="display: none;">
    <div style="display: none;">
    </div>
    <div>
        <h4>Cookie Consent</h4>
    </div>
    <div>
        <div>
            <p>This website uses cookies or similar technologies, to enhance your browsing experience and provide personalized recommendations. By continuing to use our website, you agree to our  <a style="color:#115cfa;" href="#">Privacy Policy</a></p>
            <div>
                <button onclick="acceptCookieConsent();">Accept</button>
            </div>
        </div>
    </div>
</div>

<script>
    "use strict"
    const menuArray = ["Home", "Kategorie", "Verkaufen", "Unternehmen"]
    const subMenuArray = ["Philosophie", "Karriere"]

    const menuDiv = document.createElement("div")
    menuDiv.setAttribute("id", "menu")

    const menuUL = document.createElement("ul")

    menuDiv.appendChild(menuUL)
    document.body.appendChild(menuDiv)

    menuArray.forEach(function (subMenu) {
        let li = document.createElement("li")
        let aLink = document.createElement("a")
        aLink.setAttribute("href", "#")

        let text = document.createTextNode(subMenu)

        aLink.appendChild(text)
        li.appendChild(aLink)

        if (subMenu === "Kategorie") {
            aLink.setAttribute("onclick", "showCategories()") // toggle category when click on Kategorie

            let ul = document.createElement("ul")
            ul.setAttribute("id", "categories")
            ul.style.display = "none"

            let kategorie, name
            @foreach($categories as $category)
                kategorie = document.createElement("li")
                name = '{{$category->name}}'.replace(/&amp;/g, '&')

                name = document.createTextNode(name)
                kategorie.appendChild(name)

                ul.appendChild(kategorie)
            @endforeach

            li.appendChild(ul)
        }
        // create sub Menu for Unternehmen
        else if (subMenu === "Unternehmen") {
            aLink.setAttribute("onclick", "showSubMenu()") // toggle sub menu when click Unternehmen

            let ul = document.createElement("ul")
            ul.setAttribute("id", "subMenuList")
            ul.style.display="none" // by default this sub menu will be hidden

            subMenuArray.forEach(function (sub) {
                let subLi = document.createElement("li")
                let subLink = document.createElement("a")
                subLink.setAttribute("href", "#")

                let subText = document.createTextNode(sub)

                subLink.appendChild(subText)
                subLi.appendChild(subLink)
                ul.appendChild(subLi)
                li.appendChild(ul)
            })

        }

        menuUL.appendChild(li)
    })



    function showSubMenu() {
        if (document.getElementById("subMenuList").style.display === "none")
            document.getElementById("subMenuList").style.display = "block"
        else
            document.getElementById("subMenuList").style.display = "none"
    }

    function showCategories() {
        if (document.getElementById("categories").style.display === "none")
            document.getElementById("categories").style.display = "block"
        else
            document.getElementById("categories").style.display = "none"
    }
</script>

</body>
</html>
