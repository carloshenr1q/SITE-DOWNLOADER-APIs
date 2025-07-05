# backend.py
from flask import Flask, request, jsonify
import yt_dlp

app = Flask(__name__)

@app.route('/baixar', methods=['POST'])
def baixar_video():
    url = request.json['url']
    try:
        ydl_opts = {'outtmpl': '../downloads/%(title)s.%(ext)s'}
        with yt_dlp.YoutubeDL(ydl_opts) as ydl:
            ydl.download([url])
        return jsonify({'status': 'sucesso'})
    except Exception as e:
        return jsonify({'status': 'erro', 'mensagem': str(e)}), 500

app.run(port=5000)
