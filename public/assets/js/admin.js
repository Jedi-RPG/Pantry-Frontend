/**
 * Created by Lydia on 2016-10-07.
 */

var selector, elems, makeActive;
selector = '.nav li';
elems = document.querySelectorAll(selector);

makeActive = function () {
  for (var i = 0; i < elems.length; i++)
    elems[i].classList.remove('activeSubtitle');
  this.classList.add('activeSubtitle');
};
for (var i = 0; i < elems.length; i++)
  elems[i].addEventListener('mousedown', makeActive);

var tableOne = document.getElementById("m");
var tableTwo = document.getElementById("r");
var tableThree = document.getElementById("p");

function changeTable(input){
  var name = input.innerText;
  if(name == "Receiving"){
    tableOne.className = "activeTable";
    tableTwo.className = "notActiveTable";
    tableThree.className = "notActiveTable";
  }else if(name == "Production"){
    tableOne.className = "notActiveTable";
    tableTwo.className = "activeTable";
    tableThree.className = "notActiveTable";
  }else{
    tableOne.className = "notActiveTable";
    tableTwo.className = "notActiveTable";
    tableThree.className = "activeTable";
  }
}
