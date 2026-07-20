(() => {
  const COLS = 640;
  const ROWS = 80;
  const canvas = document.getElementById('led');
  const ctx = canvas.getContext('2d');
  canvas.width = COLS;
  canvas.height = ROWS;

  // reuse ImageData buffer for faster drawing
  let imgData = ctx.createImageData(COLS, ROWS);

  let pixelBuffer = []; // array of columns, each is array of 8 booleans
  let offset = 0;
  let lastText = '';
  const fetchInterval = 500; // ms to check file (more responsive)
  const scrollMs = 1; // ms per column scroll step

  function clearBuffer(){ pixelBuffer = [] }

  function buildPixelBuffer(text){
    if(!text) text = '';
    // render text to a large offscreen canvas then scale down to height 8
    const scale = 8; // render scale
    const off = document.createElement('canvas');
    const offCtx = off.getContext('2d');
    offCtx.font = `${ROWS * scale}px 'Doto', monospace`;
    const metricsWidth = Math.ceil(offCtx.measureText(text).width || text.length * ROWS * 0.6);
    off.width = Math.max(1, metricsWidth + 10);
    off.height = ROWS * scale;
    offCtx.fillStyle = 'black';
    offCtx.fillRect(0,0,off.width,off.height);
    offCtx.fillStyle = 'white';
    offCtx.textBaseline = 'top';
    offCtx.font = `${ROWS * scale}px 'Doto', monospace`;
    offCtx.fillText(text, 0, 0);

    const small = document.createElement('canvas');
    small.width = Math.max(1, Math.ceil(off.width / scale));
    small.height = ROWS;
    const sCtx = small.getContext('2d');
    sCtx.imageSmoothingEnabled = true;
    sCtx.drawImage(off, 0,0, off.width, off.height, 0,0, small.width, small.height);

    const img = sCtx.getImageData(0,0, small.width, small.height).data;
    const cols = [];
    for(let x=0;x<small.width;x++){
      const col = [];
      for(let y=0;y<ROWS;y++){
        const idx = (y * small.width + x) * 4;
        const r = img[idx], g = img[idx+1], b = img[idx+2];
        const brightness = (r + g + b) / 3;
        col.push(brightness > 60);
      }
      cols.push(col);
    }

    // add blank columns so the message enters and exits cleanly
    const padding = COLS;
    const padded = [];
    for(let i=0;i<padding;i++) padded.push(new Array(ROWS).fill(false));
    for(const c of cols) padded.push(c);
    for(let i=0;i<padding;i++) padded.push(new Array(ROWS).fill(false));

    return padded;
  }

  function getMaxOffset(){
    return Math.max(0, pixelBuffer.length - COLS);
  }

  function draw(){
    const w = COLS, h = ROWS;
    const len = pixelBuffer.length;
    const data = imgData.data;
    // fill pixel buffer into ImageData (RGBA)
    // layout: row-major, y then x
    for(let x=0;x<w;x++){
      const srcX = x + offset;
      const col = (srcX < len) ? pixelBuffer[srcX] : new Array(h).fill(false);
      for(let y=0;y<h;y++){
        const i = (y * w + x) * 4;
        if(col[y]){
          data[i] = 0;      // r
          data[i+1] = 255;  // g
          data[i+2] = 255;  // b
          data[i+3] = 255;  // a
        } else {
          data[i] = 0;
          data[i+1] = 0;
          data[i+2] = 8;
          data[i+3] = 255;
        }
      }
    }
    ctx.putImageData(imgData, 0, 0);
  }

  let lastStep = performance.now();
  // speedFactor: 0 = stop, 0.5 = half speed, 2 = double speed
  let speedFactor = 0.5;
  let acc = 0; // fractional columns accumulator
  let pauseRemaining = 0;
  const pauseAfterCycleMs = 1000;
  function animLoop(ts){
    const elapsed = ts - lastStep;
    lastStep = ts;
    if(pauseRemaining > 0){
      pauseRemaining = Math.max(0, pauseRemaining - elapsed);
      if(pauseRemaining === 0){
        offset = 0;
        acc = 0;
        draw();
      }
      requestAnimationFrame(animLoop);
      return;
    }

    const ms = Math.max(1, scrollMs);
    const colsPerMs = 1 / ms;
    const deltaCols = elapsed * colsPerMs * speedFactor;
    acc += deltaCols;
    const steps = Math.floor(acc);
    if(steps > 0){
      const maxOffset = getMaxOffset();
      offset = Math.min(offset + steps, maxOffset);
      acc -= steps;
      draw();
      if(offset >= maxOffset){
        pauseRemaining = pauseAfterCycleMs;
      }
    }
    requestAnimationFrame(animLoop);
  }

  async function fetchText(){
    try{
      const r = await fetch('running.txt?_=' + Date.now());
      if(!r.ok) return;
      const txtRaw = await r.text();
      const txt = txtRaw.replace(/\r/g,'');

      // take the last non-empty line from the file
      const lines = txt.split('\n');
      let lastLine = '';
      for(let i = lines.length - 1; i >= 0; i--){
        if(lines[i] && lines[i].trim() !== ''){ lastLine = lines[i]; break; }
      }

      // if nothing non-empty found, consider lastLine to be empty string
      if(lastLine !== lastText){
        lastText = lastLine;
        if(lastLine.trim() === ''){
          // clear running text immediately if source last line is empty
          pixelBuffer = [];
        } else {
          pixelBuffer = buildPixelBuffer(lastLine);
        }
        offset = 0;
        draw();
      }
    }catch(e){
      // ignore network errors
      console.error('fetch error', e);
    }
  }

  // start
  clearBuffer();
  pixelBuffer = buildPixelBuffer('loading...');
  draw();
  requestAnimationFrame(animLoop);
  fetchText();
  setInterval(fetchText, fetchInterval);

  // check immediately when window becomes visible or focused
  window.addEventListener('visibilitychange', ()=>{ if(!document.hidden) fetchText(); });
  window.addEventListener('focus', ()=> fetchText());

  // expose for debugging
  window._led = {
    rebuild: ()=>{ pixelBuffer = buildPixelBuffer(lastText); },
    setSpeed: (v)=>{ speedFactor = Math.min(2, Math.max(0, Number(v) || 0)); }
  };

  // wire up UI controls if present
  try{
    const range = document.getElementById('speedRange');
    const label = document.getElementById('speedLabel');
    if(range){
      range.value = String(speedFactor);
      if(label) label.textContent = `${Number(speedFactor).toFixed(2)}×`;
      range.addEventListener('input', (e)=>{
        const v = parseFloat(e.target.value);
        window._led.setSpeed(v);
        if(label) label.textContent = `${Number(v).toFixed(2)}×`;
      });
    }
  }catch(e){/* ignore in non-browser env */}

})();
