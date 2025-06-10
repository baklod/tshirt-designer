<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>T-Shirt Designer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f0f0f0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .design-panel {
            flex: 1;
            min-width: 300px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .viewer-panel {
            flex: 1;
            min-width: 300px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        canvas { 
            border: 2px solid #ddd; 
            border-radius: 4px;
            display: block;
            margin: 0 auto;
        }
        #canvas-editor { 
            background: white;
        }
        .controls {
            margin: 20px 0;
            text-align: center;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
        }
        button:hover {
            background: #0056b3;
        }
        input[type="color"] {
            width: 50px;
            height: 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        h3 {
            color: #555;
            margin-bottom: 15px;
        }
        .color-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 10px 0;
        }
        .control-hint {
            font-size: 12px;
            color: #666;
            text-align: center;
            margin-top: 10px;
            font-style: italic;
        }
        #three-container {
            cursor: grab;
        }
        #three-container:active {
            cursor: grabbing;
        }
    </style>
</head>
<body>
    <h2>3D T-Shirt Designer</h2>
    
    <div class="container">
        <!-- Design Panel -->
        <div class="design-panel">
            <h3>Design Editor</h3>
            <canvas id="canvas-editor" width="400" height="400"></canvas>
            
            <div class="controls">
                <button id="add-text-btn">Add Text</button>
                <button id="add-circle-btn">Add Circle</button>
                <button id="add-rect-btn">Add Rectangle</button>
                <button id="clear-btn">Clear All</button>
            </div>
            
            <div class="color-controls">
                <label>T-Shirt Color:</label>
                <input type="color" id="tshirt-color" value="#ffffff">
            </div>
        </div>

        <!-- 3D Viewer Panel -->
        <div class="viewer-panel">
            <h3>3D Preview</h3>
            <div style="margin-bottom: 20px;">
                <input type="file" id="glb-file-input" accept=".glb,.gltf" style="margin-right: 10px;">
                <button id="load-glb-btn">Load GLB Model</button>
                <button id="use-basic-btn" style="margin-left: 10px;">Use Basic Model</button>
            </div>
            <div id="model-status" style="margin-bottom: 10px; padding: 10px; background: #e9ecef; border-radius: 4px; display: none;">
                <span id="status-text">Ready to load model...</span>
            </div>
            
            <!-- Three.js viewer -->
            <div id="three-container" style="width: 100%; height: 500px; position: relative;"></div>
            <div class="control-hint">Click and drag to rotate • Scroll to zoom • Double-click to reset view</div>
            
            <div class="controls">
                <button id="save-btn">Save Design</button>
                <button id="rotate-btn">Toggle Auto-Rotation</button>
                <button id="reset-view-btn">Reset View</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
    
    <!-- Three.js GLTFLoader -->
    <script>
        // GLTFLoader for Three.js r128
        (function() {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js';
            script.onload = function() {
                console.log('GLTFLoader loaded successfully');
            };
            script.onerror = function() {
                console.error('Failed to load GLTFLoader');
            };
            document.head.appendChild(script);
        })();
    </script>

    <script>
        // 1. Canvas editor using Fabric.js
        const canvas = new fabric.Canvas('canvas-editor');
        canvas.setBackgroundColor('#ffffff', canvas.renderAll.bind(canvas));

        // Add some default text
        const defaultText = new fabric.Textbox('Your Design Here!', {
            left: 100,
            top: 150,
            fontSize: 24,
            fill: '#333333',
            fontFamily: 'Arial'
        });
        canvas.add(defaultText);

        // Canvas controls
        document.getElementById('add-text-btn').addEventListener('click', () => {
            const text = new fabric.Textbox('New Text', {
                left: Math.random() * 200 + 50,
                top: Math.random() * 200 + 50,
                fontSize: 20,
                fill: '#333333'
            });
            canvas.add(text);
            canvas.setActiveObject(text); // Select the new text for immediate editing
            setTimeout(applyCanvasTexture, 100);
        });

        document.getElementById('add-circle-btn').addEventListener('click', () => {
            const circle = new fabric.Circle({
                left: Math.random() * 200 + 50,
                top: Math.random() * 200 + 50,
                radius: 30,
                fill: '#ff6b6b'
            });
            canvas.add(circle);
            canvas.setActiveObject(circle);
            setTimeout(applyCanvasTexture, 100);
        });

        document.getElementById('add-rect-btn').addEventListener('click', () => {
            const rect = new fabric.Rect({
                left: Math.random() * 200 + 50,
                top: Math.random() * 200 + 50,
                width: 60,
                height: 40,
                fill: '#4ecdc4'
            });
            canvas.add(rect);
            canvas.setActiveObject(rect);
            setTimeout(applyCanvasTexture, 100);
        });

        document.getElementById('clear-btn').addEventListener('click', () => {
            canvas.clear();
            canvas.setBackgroundColor('#ffffff', canvas.renderAll.bind(canvas));
            setTimeout(applyCanvasTexture, 100); // Apply changes to 3D model
        });

        // 2. Generate texture from canvas
        function getCanvasTexture() {
            const dataURL = canvas.toDataURL({ format: 'png' });
            const texture = new THREE.TextureLoader().load(dataURL);
            texture.needsUpdate = true;
            return texture;
        }

        // 3. THREE.js setup with improved controls
        let scene, camera, renderer, tshirtMesh, tshirtMaterial;
        let isAutoRotating = true;
        let containerWidth, containerHeight;
        let currentModelType = 'basic';
        let loadedGLBModel = null;

        // Camera controls
        let cameraControls = {
            rotationX: 0,
            rotationY: 0,
            distance: 5,
            targetDistance: 5,
            isMouseDown: false,
            lastMouseX: 0,
            lastMouseY: 0,
            autoRotateSpeed: 0.005,
            dampingFactor: 0.1
        };

        // Model centering
        let modelCenter = new THREE.Vector3();
        let modelSize = new THREE.Vector3();

        initThree();

        function initThree() {
            const container = document.getElementById('three-container');
            containerWidth = container.clientWidth;
            containerHeight = container.clientHeight;

            scene = new THREE.Scene();
            scene.background = new THREE.Color(0xf0f0f0);
            
            camera = new THREE.PerspectiveCamera(45, containerWidth / containerHeight, 0.1, 1000);
            
            renderer = new THREE.WebGLRenderer({ antialias: true });
            renderer.setSize(containerWidth, containerHeight);
            renderer.shadowMap.enabled = true;
            renderer.shadowMap.type = THREE.PCFSoftShadowMap;
            container.appendChild(renderer.domElement);

            // Lighting
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
            scene.add(ambientLight);

            const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
            directionalLight.position.set(10, 10, 5);
            directionalLight.castShadow = true;
            scene.add(directionalLight);

            // Create basic t-shirt geometry by default
            createBasicTShirt();
            
            // Apply initial canvas texture
            applyCanvasTexture();
            
            // Setup controls
            setupMouseControls();
            setupKeyboardControls();
            
            animate();
        }

        function createBasicTShirt() {
            // Remove existing model
            if (tshirtMesh) {
                scene.remove(tshirtMesh);
            }

            // Create a simple t-shirt shape using multiple geometries
            const group = new THREE.Group();

            // Main body (front)
            const bodyGeometry = new THREE.PlaneGeometry(2, 2.5);
            tshirtMaterial = new THREE.MeshLambertMaterial({
                color: 0xffffff,
                side: THREE.DoubleSide
            });
            const bodyMesh = new THREE.Mesh(bodyGeometry, tshirtMaterial);
            bodyMesh.position.z = 0.1;
            bodyMesh.name = 'tshirt_front';
            group.add(bodyMesh);

            // Back of shirt
            const backMaterial = new THREE.MeshLambertMaterial({
                color: 0xffffff,
                side: THREE.DoubleSide
            });
            const backMesh = new THREE.Mesh(bodyGeometry, backMaterial);
            backMesh.position.z = -0.1;
            backMesh.rotation.y = Math.PI;
            group.add(backMesh);

            // Sleeves
            const sleeveGeometry = new THREE.CylinderGeometry(0.3, 0.4, 1, 8);
            const sleeveMaterial = new THREE.MeshLambertMaterial({ color: 0xffffff });
            
            const leftSleeve = new THREE.Mesh(sleeveGeometry, sleeveMaterial);
            leftSleeve.position.set(-1.2, 0.5, 0);
            leftSleeve.rotation.z = Math.PI / 2;
            group.add(leftSleeve);

            const rightSleeve = new THREE.Mesh(sleeveGeometry, sleeveMaterial);
            rightSleeve.position.set(1.2, 0.5, 0);
            rightSleeve.rotation.z = -Math.PI / 2;
            group.add(rightSleeve);

            // Collar
            const collarGeometry = new THREE.TorusGeometry(0.4, 0.1, 8, 16, Math.PI);
            const collarMaterial = new THREE.MeshLambertMaterial({ color: 0xffffff });
            const collar = new THREE.Mesh(collarGeometry, collarMaterial);
            collar.position.set(0, 1, 0);
            collar.rotation.x = Math.PI;
            group.add(collar);

            tshirtMesh = group;
            currentModelType = 'basic';
            scene.add(tshirtMesh);
            
            // Center the model
            centerModel();
            
            showStatus('Basic t-shirt model loaded', 'success');
        }

        function loadGLBModel(file) {
            showStatus('Loading GLB model...', 'loading');
            
            if (typeof THREE.GLTFLoader === 'undefined') {
                showStatus('GLTFLoader not available. Please refresh the page.', 'error');
                return;
            }

            const loader = new THREE.GLTFLoader();
            const url = URL.createObjectURL(file);
            
            loader.load(
                url,
                function(gltf) {
                    if (tshirtMesh) {
                        scene.remove(tshirtMesh);
                    }
                    
                    loadedGLBModel = gltf.scene;
                    tshirtMesh = loadedGLBModel;
                    currentModelType = 'glb';
                    
                    scene.add(tshirtMesh);
                    
                    // Center and scale the model
                    centerModel();
                    
                    // Apply canvas texture
                    applyCanvasTexture();
                    
                    showStatus('GLB model loaded successfully!', 'success');
                    URL.revokeObjectURL(url);
                },
                function(progress) {
                    const percent = Math.round((progress.loaded / progress.total) * 100);
                    showStatus(`Loading GLB model... ${percent}%`, 'loading');
                },
                function(error) {
                    console.error('Error loading GLB:', error);
                    showStatus('Failed to load GLB model. Please check the file format.', 'error');
                    URL.revokeObjectURL(url);
                }
            );
        }

        function centerModel() {
            if (!tshirtMesh) return;
            
            // Calculate bounding box
            const box = new THREE.Box3().setFromObject(tshirtMesh);
            box.getSize(modelSize);
            box.getCenter(modelCenter);
            
            // Scale model to fit nicely in view
            const maxSize = Math.max(modelSize.x, modelSize.y, modelSize.z);
            const scale = 3 / maxSize;
            tshirtMesh.scale.setScalar(scale);
            
            // Center the model
            tshirtMesh.position.sub(modelCenter.multiplyScalar(scale));
            
            // Reset camera distance based on model size
            cameraControls.distance = cameraControls.targetDistance = Math.max(4, maxSize * 1.5);
        }

        function setupMouseControls() {
            const container = document.getElementById('three-container');
            
            // Mouse events
            container.addEventListener('mousedown', onMouseDown);
            container.addEventListener('mousemove', onMouseMove);
            container.addEventListener('mouseup', onMouseUp);
            container.addEventListener('mouseleave', onMouseUp);
            
            // Touch events for mobile
            container.addEventListener('touchstart', onTouchStart);
            container.addEventListener('touchmove', onTouchMove);
            container.addEventListener('touchend', onTouchEnd);
            
            // Wheel event for zooming
            container.addEventListener('wheel', onWheel);
            
            // Double click to reset view
            container.addEventListener('dblclick', resetView);
        }

        function setupKeyboardControls() {
            document.addEventListener('keydown', (e) => {
                switch(e.key) {
                    case 'r':
                    case 'R':
                        resetView();
                        break;
                    case ' ':
                        e.preventDefault();
                        toggleAutoRotation();
                        break;
                }
            });
        }

        function onMouseDown(event) {
            event.preventDefault();
            cameraControls.isMouseDown = true;
            cameraControls.lastMouseX = event.clientX;
            cameraControls.lastMouseY = event.clientY;
            isAutoRotating = false;
        }

        function onMouseMove(event) {
            if (!cameraControls.isMouseDown) return;
            
            const deltaX = event.clientX - cameraControls.lastMouseX;
            const deltaY = event.clientY - cameraControls.lastMouseY;
            
            // Smooth rotation with sensitivity adjustment
            cameraControls.rotationY += deltaX * 0.005;
            cameraControls.rotationX += deltaY * 0.005;
            
            // Clamp vertical rotation to prevent flipping
            cameraControls.rotationX = Math.max(-Math.PI/2, Math.min(Math.PI/2, cameraControls.rotationX));
            
            cameraControls.lastMouseX = event.clientX;
            cameraControls.lastMouseY = event.clientY;
        }

        function onMouseUp(event) {
            event.preventDefault();
            cameraControls.isMouseDown = false;
        }

        // Touch events
        function onTouchStart(event) {
            event.preventDefault();
            if (event.touches.length === 1) {
                cameraControls.isMouseDown = true;
                cameraControls.lastMouseX = event.touches[0].clientX;
                cameraControls.lastMouseY = event.touches[0].clientY;
                isAutoRotating = false;
            }
        }

        function onTouchMove(event) {
            event.preventDefault();
            if (event.touches.length === 1 && cameraControls.isMouseDown) {
                const deltaX = event.touches[0].clientX - cameraControls.lastMouseX;
                const deltaY = event.touches[0].clientY - cameraControls.lastMouseY;
                
                cameraControls.rotationY += deltaX * 0.005;
                cameraControls.rotationX += deltaY * 0.005;
                cameraControls.rotationX = Math.max(-Math.PI/2, Math.min(Math.PI/2, cameraControls.rotationX));
                
                cameraControls.lastMouseX = event.touches[0].clientX;
                cameraControls.lastMouseY = event.touches[0].clientY;
            }
        }

        function onTouchEnd(event) {
            event.preventDefault();
            cameraControls.isMouseDown = false;
        }

        function onWheel(event) {
            event.preventDefault();
            
            // Zoom with mouse wheel
            const delta = event.deltaY > 0 ? 1.1 : 0.9;
            cameraControls.targetDistance *= delta;
            cameraControls.targetDistance = Math.max(2, Math.min(20, cameraControls.targetDistance));
        }

        function updateCamera() {
            // Smooth camera movement with damping
            cameraControls.distance += (cameraControls.targetDistance - cameraControls.distance) * cameraControls.dampingFactor;
            
            // Auto rotation
            if (isAutoRotating) {
                cameraControls.rotationY += cameraControls.autoRotateSpeed;
            }
            
            // Calculate camera position
            const x = cameraControls.distance * Math.sin(cameraControls.rotationY) * Math.cos(cameraControls.rotationX);
            const y = cameraControls.distance * Math.sin(cameraControls.rotationX);
            const z = cameraControls.distance * Math.cos(cameraControls.rotationY) * Math.cos(cameraControls.rotationX);
            
            camera.position.set(x, y, z);
            camera.lookAt(0, 0, 0);
        }

        function resetView() {
            cameraControls.rotationX = 0;
            cameraControls.rotationY = 0;
            cameraControls.targetDistance = 5;
            cameraControls.distance = 5;
            isAutoRotating = true;
        }

        function toggleAutoRotation() {
            isAutoRotating = !isAutoRotating;
            document.getElementById('rotate-btn').textContent = isAutoRotating ? 'Stop Auto-Rotation' : 'Start Auto-Rotation';
        }

        function showStatus(message, type) {
            const statusDiv = document.getElementById('model-status');
            const statusText = document.getElementById('status-text');
            
            statusText.textContent = message;
            statusDiv.style.display = 'block';
            
            switch(type) {
                case 'success':
                    statusDiv.style.background = '#d4edda';
                    statusDiv.style.color = '#155724';
                    break;
                case 'error':
                    statusDiv.style.background = '#f8d7da';
                    statusDiv.style.color = '#721c24';
                    break;
                case 'loading':
                    statusDiv.style.background = '#fff3cd';
                    statusDiv.style.color = '#856404';
                    break;
                default:
                    statusDiv.style.background = '#e9ecef';
                    statusDiv.style.color = '#495057';
            }
            
            if (type === 'success') {
                setTimeout(() => {
                    statusDiv.style.display = 'none';
                }, 3000);
            }
        }

        function applyCanvasTexture() {
            if (!tshirtMesh) return;
            
            const texture = getCanvasTexture();
            texture.needsUpdate = true;
            texture.flipY = false; // Fix texture orientation
            
            if (currentModelType === 'basic') {
                const frontMesh = tshirtMesh.children.find(child => child.name === 'tshirt_front');
                if (frontMesh) {
                    frontMesh.material.map = texture;
                    frontMesh.material.needsUpdate = true;
                }
            } else if (currentModelType === 'glb') {
                // Apply texture to GLB model materials
                tshirtMesh.traverse(child => {
                    if (child.isMesh && child.material) {
                        if (Array.isArray(child.material)) {
                            // Handle multiple materials
                            child.material.forEach(mat => {
                                if (mat.name && (
                                    mat.name.toLowerCase().includes('front') ||
                                    mat.name.toLowerCase().includes('shirt') ||
                                    mat.name.toLowerCase().includes('body') ||
                                    mat.name.toLowerCase().includes('main')
                                )) {
                                    mat.map = texture;
                                    mat.needsUpdate = true;
                                } else if (!mat.name && !mat.map) {
                                    // Apply to first material without a name or existing texture
                                    mat.map = texture;
                                    mat.needsUpdate = true;
                                }
                            });
                        } else {
                            // Single material
                            if (child.material.name && (
                                child.material.name.toLowerCase().includes('front') ||
                                child.material.name.toLowerCase().includes('shirt') ||
                                child.material.name.toLowerCase().includes('body') ||
                                child.material.name.toLowerCase().includes('main')
                            )) {
                                child.material.map = texture;
                                child.material.needsUpdate = true;
                            } else if (!child.material.name && !child.material.map) {
                                // Apply to materials without names or existing textures
                                child.material.map = texture;
                                child.material.needsUpdate = true;
                            }
                        }
                    }
                });
            }
        }

        function animate() {
            requestAnimationFrame(animate);
            
            updateCamera();
            renderer.render(scene, camera);
        }

        // Color controls
        document.getElementById('tshirt-color').addEventListener('change', (e) => {
            const color = new THREE.Color(e.target.value);
            if (tshirtMesh) {
                if (currentModelType === 'basic') {
                    // Apply color to all parts of basic model
                    tshirtMesh.children.forEach(child => {
                        if (child.material) {
                            child.material.color = color;
                            child.material.needsUpdate = true;
                        }
                    });
                } else if (currentModelType === 'glb') {
                    // Apply color to GLB model materials
                    tshirtMesh.traverse(child => {
                        if (child.isMesh && child.material) {
                            if (Array.isArray(child.material)) {
                                child.material.forEach(mat => {
                                    mat.color = color;
                                    mat.needsUpdate = true;
                                });
                            } else {
                                child.material.color = color;
                                child.material.needsUpdate = true;
                            }
                        }
                    });
                }
            }
        });

        // GLB Loading controls
        document.getElementById('load-glb-btn').addEventListener('click', () => {
            const fileInput = document.getElementById('glb-file-input');
            const file = fileInput.files[0];
            
            if (!file) {
                showStatus('Please select a GLB file first', 'error');
                return;
            }
            
            if (!file.name.toLowerCase().endsWith('.glb') && !file.name.toLowerCase().endsWith('.gltf')) {
                showStatus('Please select a valid GLB or GLTF file', 'error');
                return;
            }
            
            loadGLBModel(file);
        });

        document.getElementById('use-basic-btn').addEventListener('click', () => {
            createBasicTShirt();
            applyCanvasTexture();
        });

        // Control buttons
        document.getElementById('rotate-btn').addEventListener('click', toggleAutoRotation);
        document.getElementById('reset-view-btn').addEventListener('click', resetView);

        // Update texture when canvas changes - with immediate application
        canvas.on('object:modified', () => {
            setTimeout(applyCanvasTexture, 100); // Small delay to ensure canvas is updated
        });
        canvas.on('object:added', () => {
            setTimeout(applyCanvasTexture, 100);
        });
        canvas.on('object:removed', () => {
            setTimeout(applyCanvasTexture, 100);
        });
        canvas.on('path:created', () => {
            setTimeout(applyCanvasTexture, 100);
        });
        canvas.on('text:changed', () => {
            setTimeout(applyCanvasTexture, 100);
        });
        canvas.on('object:scaling', () => {
            setTimeout(applyCanvasTexture, 100);
        });
        canvas.on('object:rotating', () => {
            setTimeout(applyCanvasTexture, 100);
        });
        canvas.on('object:moving', () => {
            setTimeout(applyCanvasTexture, 100);
        });

        // Save functionality
        document.getElementById('save-btn').addEventListener('click', function () {
            const dataURL = canvas.toDataURL('image/png');
            
            const link = document.createElement('a');
            link.download = 'tshirt-design.png';
            link.href = dataURL;
            link.click();
            
            alert('Design saved as PNG file!');
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            const container = document.getElementById('three-container');
            const newWidth = container.clientWidth;
            const newHeight = container.clientHeight;
            
            camera.aspect = newWidth / newHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(newWidth, newHeight);
        });
    </script>
</body>
</html>