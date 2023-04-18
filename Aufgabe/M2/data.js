var data= {
    'produkte': [
        { name: 'Ritterburg', preis: 59.99, kategorie: 1, anzahl: 3 },
        { name: 'Gartenschlau 10m', preis: 6.50, kategorie: 2, anzahl: 5 },
        { name: 'Robomaster' ,preis: 199.99, kategorie: 1, anzahl: 2 },
        { name: 'Pool 250x400', preis: 250, kategorie: 2, anzahl: 8 },
        { name: 'Rasenmähroboter', preis: 380.95, kategorie: 2, anzahl: 4 },
        { name: 'Prinzessinnenschloss', preis: 59.99, kategorie: 1, anzahl: 5 }
    ],
    'kategorien': [
        { id: 1, name: 'Spielzeug' },
        { id: 2, name: 'Garten' }
    ]
}

function getMaxPrice() {
    let maxPrice, maxProduct

    // find the max price in all product objects
    maxPrice = Math.max.apply(null,
        data.produkte.map(function (product) {
            return product.preis
        }))

    // find that product object
    maxProduct = data.produkte.find((product) => product.preis === maxPrice)

    return [maxProduct.name, maxProduct.preis]
}

function getMinPriceProduct() {
    let minPrice, minProduct

    // find the min price in all product objects
    minPrice = Math.min.apply(null,
        data.produkte.map(function (product) {
            return product.preis
        }))

    // find that product object
    minProduct = data.produkte.find((product) => product.preis === minPrice)

    return minProduct
}

function getPriceSum() {
    let sum = 0

    data.produkte.forEach(function (product) {
        sum = sum + product.preis
    })

    // round final sum to 2 decimal places
    return Math.round(sum * 100) / 100
}

function getTotalValue() {
    let sum = 0

    data.produkte.forEach(function (product) {
        sum = sum + product.preis * product.anzahl
    })

    // round final sum to 2 decimal places
    return Math.round(sum * 100) / 100
}

function getTotalProductOfCategory() {
    let toy = 0, garden = 0
    let result = {}

    data.produkte.forEach(function (product) {
        if (product.kategorie === 1)
            toy = toy + product.anzahl
        else
            garden = garden + product.anzahl

    })

    result[data.kategorien[0].name] = toy
    result[data.kategorien[1].name] = garden

    return result
}

let product = getTotalProductOfCategory()
console.log(product)
