<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>три в ряд</title>
  </head>
  <body>
    


<style>
  [class^='col']{
    min-height: 50px !important;
    min-width: 50px !important;
    border: 3px solid black;
    border-radius: 100%;
    
  }
  .cell {
  height: 51px;
  width: 51px;
  }
  
</style>
<script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
<script>

let colors = ["red", "blue", "green"];

//alert (color);
let x = '';
let gems = [
 /* [x, x, x, x, x, x, x],// = y[0] = gems[0][...]
  [x, x, x, x, x, x, x],
  [x, x, x, x, x, x, x],
  [x, x, x, x, x, x, x],
  [x, x, x, x, x, x, x],
  [x, x, x, x, x, x, x],
  [x, x, x, x, x, x, x],*/
];
let colGems = [];
let gemsSelected = {oldGem: null, newGem: null};
let popStones = 0;




function createStone(color, cell, id){// , id
  let father = document.getElementById(id)
  //let cell = father.firstChild;
  

  let stone = document.createElement("div");
  stone.setAttribute("class", "col-1 m-1");
  stone.style.backgroundColor = color;
  stone.style.cursor = "pointer";
  
  stone.onclick = selectGem;//вызов по щелчку
  //stone.id = id;
  //var divStone = document.querySelector("div:last-child > div:last-child");
  
  switch(color){
    case 'red':
      stone.setAttribute("color", "red");
      break;
    case 'blue':
      stone.setAttribute("color", "blue");
      break;
    case 'green':
      stone.setAttribute("color", "green");
      break;
  }
  
  father.append(stone);

}

  function createField (M, N){
    var containerDiv = document.createElement('div');
    containerDiv.className = 'container';
    document.body.append(containerDiv);
    for (i=0; i<M; i++){
      var rowDiv = document.createElement('div');
      rowDiv.className = 'row';//  justify-content-center
      containerDiv.append(rowDiv);
      gems[i] = [];
      for (j=0; j<N; j++){
        var color = colors[Math.floor(Math.random()*colors.length)];
        let cell = document.createElement('div');
        id = cell.id = i + "." + j; //задаем уникальный номер каждой "ячейке" матрицы
        cell.setAttribute("class", "cell");
        rowDiv.append(cell);
        createStone(color, cell, id);
        gems[i].push(color);
      } 
    }
    //------счет-------
    
   let scoreDiv = document.createElement('div');
   scoreDiv.className = "row m-2";
   scoreDiv.id = "score";
   containerDiv.appendChild(scoreDiv);
   let score = document.getElementById('score');
   score.innerHTML = '<span>Ваш счет: </span><span class="popStones">0</span>';
    //кнопка для проверки findRow
    let input = document.createElement("input");
    input.type = "button";
    input.value = "POP row";
    input.className = 'btn btn-primary m-1';
    input.onclick = findRow;
    containerDiv.appendChild(input);
    input = document.createElement("input");
    input.type = "button";
    input.value = "POP column";
    input.className = 'btn btn-primary m-1';
    input.onclick = findCol;
    containerDiv.appendChild(input);
    

    return gems;
  }
  
  
function popStone(id){
  
  let father = document.getElementById(id)
  console.log(id);
  let dead = father.firstChild;
  dead.remove();
  popStones++;
  $(".popStones").html(popStones);
}

function newStone(id){
  let father = document.getElementById(id)
  var color = colors[Math.floor(Math.random()*colors.length)];
  let matrixColor = id.split(".");
  gems[matrixColor[0]][matrixColor[1]] = color;
  colGems[matrixColor[1]][matrixColor[0]] = color;
  let stone = document.createElement("div");
    stone.setAttribute("class", "col-1 m-1");
    stone.style.backgroundColor = color;
    stone.style.cursor = "pointer";
    stone.onclick = selectGem;//вызов по щелчку
    switch(color){
    case 'red':
      stone.setAttribute("color", "red");
      break;
    case 'blue':
      stone.setAttribute("color", "blue");
      break;
    case 'green':
      stone.setAttribute("color", "green");
      break;
    }
  father.append(stone);
  
}



//------------подготовка к функции перемены мест камней

/*let firstEl = document.getElementById(id); 
  let firstSon = firstEl.firstElementChild;
let secondEl = document.getElementById(id).nextSibling;
  let secondSon = secondEl.firstElementChild;
firstEl.append(secondSon);
secondElappend(firstSon);*/

/*---------------ПРИМЕР-----------------
let firstElem = document.getElementById(id);
let secondElem = document.getElementById(id).nextSibling;
let oldGem = secondElem.firstElementChild;
let newGem = firstElem.firstElementChild;
firstElem.append(oldGem);
secondElem.append(newGem);
------
let gemsSelected = {oldGem: null, newGem: null}

gem.onclick = selectGem;
function selectGem() {
 //Функция записывает в камни в объект gemsSelected
}

*/




function selectGem() {

  let selected = this; // див камня
  
  if (gemsSelected.oldGem == null){  
    gemsSelected.oldGem = selected;// запись в объект
    //selected.firstElementChild.style.border = "3px solid magenta";
  }else if(gemsSelected.oldGem != null && gemsSelected.newGem == null){
    gemsSelected.newGem = selected;// запись в объект
  //}else if(gemsSelected.oldGem != null && gemsSelected.newGem != null){
    //console.log(gemsSelected);
    // по вертикали
    let oldParent = gemsSelected.oldGem.parentNode;
    let newParent = gemsSelected.newGem.parentNode;
    
    //по горизонтали
    let fatherID = this.parentNode.id;
    let coords = fatherID.split("."); //потрошим айди в массив
    let topCoord = (coords[0] - 1) + '.' + coords[1]; //пишем координату верхнего соседа
    let botCoord = (coords[0] - -1) + '.' + coords[1]; //пишем координату нижнего соседа
    let topNeighbor = document.getElementById(topCoord);
    let botNeighbor = document.getElementById(botCoord);
    //console.log("координаты", coords)
    //console.log(topCoord, "верхний")
    //console.log(botCoord, "нижний")
    
    
    
    if ((oldParent == newParent.previousSibling || oldParent == newParent.nextSibling) || (oldParent == topNeighbor || oldParent == botNeighbor)){

      oldParent.append(gemsSelected.newGem);
      id = newParent.id
      let matrixColor = id.split(".");
      gems[matrixColor[0]][matrixColor[1]] = gemsSelected.oldGem.getAttribute('color');
      colGems[matrixColor[1]][matrixColor[0]] = gemsSelected.oldGem.getAttribute('color');
      
      
      newParent.append(gemsSelected.oldGem);
      id = oldParent.id
      matrixColor = id.split(".");
      gems[matrixColor[0]][matrixColor[1]] = gemsSelected.newGem.getAttribute('color');
      colGems[matrixColor[1]][matrixColor[0]] = gemsSelected.newGem.getAttribute('color');
      //console.log(gems)
      //console.log(colGems)
      
     // gemsSelected = {oldGem: null, newGem: null};
    }
      gemsSelected = {oldGem: null, newGem: null};
  }
  //let gem = document.getElementById(id);
  
 //Функция записывает в камни в объект gemsSelected
}




function findRow(){
  //console.log("работает");
let rowOfStones = []; //для проверки количества совпадений в ряду
let targets = []; // для сбора айдишников тех элементов, которые будут удаляться


  for (let i=0; i<gems.length; i++){
    for (let j=0; j<gems[i].length; j++){
//--------------------часть, отвечающая за строки----------------

      if(gems[i][j] == gems[i][j+1]){
        rowOfStones.push(gems[i][j]);
        //!!!
        targets.push([i] + "." + [j]);
        //!!!
        //console.log(j);
        //console.log(targets);
      }else{
        if(rowOfStones.length + 1 < 3){
          rowOfStones = [];//сброс
          targets = [];//сброс
        }else if(rowOfStones.length + 1 >= 3){//если ряд камней получился больше 2-х
          rowOfStones = [];// отработал, больше не нужен
          
            targets.push([i] + "." + [j]);//добавим айдишник последнего камня
            //console.log(targets);
            //console.log("эта ",j);
          
            for (let u=0; u<targets.length; u++){//ниже берем по одному айдишнику и применяем функции удаления камня и замены его случайным
              targets.unshift("болванка");
              console.log(targets);

              let pop = targets.pop();
              console.log(targets);
              popStone(pop);
              newStone(pop);
            }
            //targets = []; //закоментирован так как должен сам таким стать
        }
      }
 
    }
  }
}
function findCol(){
let colOfStones = []; //для проверки количества совпадений в ряду
let targets = []; // для сбора айдишников тех элементов, которые будут удаляться

  for (let i=0; i<colGems.length; i++){
    for (let j=0; j<colGems[i].length; j++){

       if(colGems[i][j] == colGems[i][j+1]){
        //console.log(i,j);
        colOfStones.push(colGems[i][j]);
        targets.push([j] + "." + [i]);
        
        
        
      }else{
        if(colOfStones.length < 2){
          colOfStones = [];//сброс
          targets = [];//сброс
        }else if(colOfStones.length >= 2){//если ряд камней получился больше 2-х
          colOfStones = [];// отработал, больше не нужен
          targets.push([j] + "." + [i]);//добавим айдишник последнего камня
          
          
            for (let u=0; u<targets.length; u++){//ниже берем по одному айдишнику и применяем функции удаления камня и замены его случайным
              targets.unshift("болванка");
              console.log(targets);

              let pop = targets.pop();
              console.log(targets);
              popStone(pop);
              newStone(pop);
            }
            targets = [];//сброс
        }
      }
    }
  }
}

console.log(createField(6, 6));

for (let i=0; i<gems.length; i++){ //создание массивов в массиве
  colGems[i] = [];
}

for (let i=0; i<gems.length; i++){
  
  for (let j=0; j<gems[i].length; j++){
    colGems[i].push(gems[j][i]);
  }
}
console.log(colGems)



</script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>