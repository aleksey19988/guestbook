export default function(cookies) {
    let result = {};

    if (cookies.length < 1) {
        return result;
    }
    let arrayCookies = cookies.split(';');

    for (let i = 0; i < arrayCookies.length; i++) {
        let property = arrayCookies[i].split('=')[0].trim();
        let value = decodeURIComponent(arrayCookies[i].split('=')[1].trim());
        result[property] = value;
    }

    return result;
}