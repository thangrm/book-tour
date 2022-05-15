function leftRange(el) {
    let value = (100 / (parseInt(el.max) - parseInt(el.min))) * parseInt(el.value) - (100 / (parseInt(el.max) - parseInt(el.min))) * parseInt(el.min);
    let children = el.parentNode.childNodes[1].childNodes;
    children[1].style.width = value + '%';
    children[5].style.left = value + '%';
    children[7].style.left = value + '%';
    children[11].style.left = value + '%';
    children[11].childNodes[1].innerHTML = Number(el.value).toLocaleString();
}

function rightRange(el) {
    let value = (100 / (parseInt(el.max) - parseInt(el.min))) * parseInt(el.value) - (100 / (parseInt(el.max) - parseInt(el.min))) * parseInt(el.min);
    let children = el.parentNode.childNodes[1].childNodes;
    children[3].style.width = (100 - value) + '%';
    children[5].style.right = (100 - value) + '%';
    children[9].style.left = value + '%';
    children[13].style.left = value + '%';
    children[13].childNodes[1].innerHTML = Number(el.value).toLocaleString();
}

if (document.getElementById('minPrice') !== null) {
    leftRange(document.getElementById('minPrice'));
    rightRange(document.getElementById('maxPrice'));
}
