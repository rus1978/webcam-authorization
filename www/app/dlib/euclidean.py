import dlib
from skimage import io
from scipy.spatial import distance
import sys
import os.path
import json


imageSrc =  '../storage/app/auth/users/' + sys.argv[1]
imageDist = sys.argv[2]

facerec = dlib.face_recognition_model_v1('../app/dlib/dlib_face_recognition_resnet_model_v1.dat')
sp = dlib.shape_predictor('../app/dlib/shape_predictor_68_face_landmarks.dat')

detector = dlib.get_frontal_face_detector()

img = io.imread(imageSrc)


# Находим лицо на фотографии
dets = detector(img, 1)

for k, d in enumerate(dets):
    #print("Detection {}: Left: {} Top: {} Right: {} Bottom: {}".format(
    #    k, d.left(), d.top(), d.right(), d.bottom()))
    shape = sp(img, d)
#     win1.clear_overlay()
#     win1.add_overlay(d)
#     win1.add_overlay(shape)

# Извлекаем дескриптор из лица
face_descriptor1 = facerec.compute_face_descriptor(img, shape)
# print(face_descriptor1)

# print('|'+sys.argv[1] + '|')

if os.path.isfile(imageDist):
    img = io.imread(imageDist)
    # win2 = dlib.image_window()
    # win2.clear_overlay()
    # win2.set_image(img)
    dets_webcam = detector(img, 1)
    for k, d in enumerate(dets_webcam):
        #print("Detection {}: Left: {} Top: {} Right: {} Bottom: {}".format(
         #   k, d.left(), d.top(), d.right(), d.bottom()))
        shape = sp(img, d)
    #     win2.clear_overlay()
    #     win2.add_overlay(d)
    #     win2.add_overlay(shape)

    face_descriptor2 = facerec.compute_face_descriptor(img, shape)

    a = distance.euclidean(face_descriptor1, face_descriptor2)

    response = {
        'status': 'success',
        'match': a < 0.6,
        'distanceEuclidean': a,
        #'faceArea': dets
    }

else:
    response = {
        'status': 'error',
        'message': 'image not found'
    }

print(json.dumps(response))