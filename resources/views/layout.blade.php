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

    // Menu as object
    const menu = {
        Home: [],
        Kategorie: [],
        Verkaufen: [],
        Unternehmen: ["Philosophie", "Karriere"]
    }

    // push categories into Kategorie
    @foreach($categories as $category)
        menu.Kategorie.push("{{$category->name}}".replace(/&amp;/g, '&'))
    @endforeach

    console.log(menu)

    const menuDiv = document.createElement("div")
    menuDiv.setAttribute("id", "menu")

    const menuUL = document.createElement("ul")

    menuDiv.appendChild(menuUL)
    document.body.appendChild(menuDiv)

    Object.keys(menu).forEach(function (menuKey) {
        let li = document.createElement("li")
        let aLink = document.createElement("a")
        aLink.setAttribute("href", "#")

        let text = document.createTextNode(menuKey)

        aLink.appendChild(text)
        li.appendChild(aLink)

        if (menuKey === "Kategorie") {
            aLink.setAttribute("onclick", "showCategories()") // toggle category when click on Kategorie

            let ul = document.createElement("ul")
            ul.setAttribute("id", "categories")
            ul.style.display = "none"

            menu.Kategorie.forEach(function (category) {
                let kategorie = document.createElement("li")
                kategorie.appendChild(document.createTextNode(category))
                ul.appendChild(kategorie)
            })
            li.appendChild(ul)
        }
        if (menuKey === "Unternehmen") {
            aLink.setAttribute("onclick", "showSubMenu()") // toggle sub menu when click Unternehmen

            let ul = document.createElement("ul")
            ul.setAttribute("id", "subMenuList")
            ul.style.display="none" // by default this sub menu will be hidden

            menu.Unternehmen.forEach(function (subMenu) {
                let subLi = document.createElement("li")
                let subLink = document.createElement("a")
                subLink.setAttribute("href", "#")

                let subText = document.createTextNode(subMenu)

                subLink.appendChild(subText)
                subLi.appendChild(subLink)
                ul.appendChild(subLi)
                li.appendChild(ul)
            })
        }

        menuUL.appendChild(li)
    })

</script>

</body>
</html>
