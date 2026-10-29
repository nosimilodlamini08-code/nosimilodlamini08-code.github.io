import base64
import cv2
import numpy as np
from flask import Flask, request, jsonify
from flask_cors import CORS
import face_recognition

app = Flask(__name__)
CORS(app)  # Allows connection from your frontend XAMPP code local port

@app.route('/api/analyze-face', methods=['POST'])
def analyze_face():
    try:
        data = request.json
        image_data = data.get('image').split(',')[1]
        
        # Decode base64 stream directly back into image matrix byte allocations
        nparr = np.frombuffer(base64.b64decode(image_data), np.uint8)
        img = cv2.imdecode(nparr, cv2.IMREAD_COLOR)
        
        # Convert BGR (OpenCV format) to RGB (face_recognition format)
        rgb_img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
        
        # Generate biometric mappings
        encodings = face_recognition.face_encodings(rgb_img)
        
        if len(encodings) > 0:
            # Send the 128-dimensional array numbers down to the signup form pipeline
            face_list = encodings[0].tolist()
            return jsonify({"success": True, "encoding": face_list})
        else:
            return jsonify({"success": False, "message": "No clear face structures detected"})
            
    except Exception as e:
        return jsonify({"success": False, "message": str(e)})

if __name__ == '__main__':
    app.run(port=5000, debug=True)