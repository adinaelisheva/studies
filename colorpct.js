window.onload = () => {
  document.querySelectorAll('.score').forEach((e) => {
    const pct = e.innerText.substring(0, e.innerText.length - 1); // Chop off the '%'
    e.setAttribute('style', `color: ${getPctStyle(pct)};`);
  });
}

//function to interpolate colors and return an RGB style string
function getPctStyle(pct) {
  let color = [0,0,0];
  
  //colors for interpolation
  let red = [95,4,4];
  let yellow = [117,92,2];
  let green = [15,124,15];
    
  if (pct >= 100) {
    color = green;
  }
  else if (pct <= 0) {
    color = red;
  }
  else if(pct < 50) {
    //interpolate between red and yellow
    const curPct = pct/50;
    color[0] = Math.round(red[0] + curPct * (yellow[0] - red[0]));
    color[1] = Math.round(red[1] + curPct * (yellow[1] - red[1]));
    color[2] = Math.round(red[2] + curPct * (yellow[2] - red[2]));
  }  
  else {
    //interpolate between yellow and green
    const curPct = (pct - 50)/50;
    color[0] = Math.round(yellow[0] + curPct * (green[0] - yellow[0]));
    color[1] = Math.round(yellow[1] + curPct * (green[1] - yellow[1]));
    color[2] = Math.round(yellow[2] + curPct * (green[2] - yellow[2]));
  }

  pct = Math.max(0,Math.min(100,pct * 100));

  return `rgb(${color[0]},${color[1]},${color[2]})`;
}