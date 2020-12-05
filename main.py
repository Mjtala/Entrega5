from flask import Flask, json, request, abort, render_template
from pymongo import MongoClient, TEXT
from werkzeug.exceptions import BadRequest
import pymongo
import os

USER = "grupo19"
PASS = "grupo19"
DATABASE = "grupo19"

URL = f"mongodb://{USER}:{PASS}@gray.ing.puc.cl/{DATABASE}?authSource=admin"
client = MongoClient(URL)

USER_KEYS = ['uid', 'name','age', 'description']
MENSAJES_KEYS = ['mid', 'message', 'sender', 'receptant', 'lat', 'long', 'date']
SEARCH_KEYS = ["desired", "required", "forbidden", "userId"]

# Base de datos del grupo
db = client["grupo19"]

# Seleccionamos la collección de usuarios
usuarios = db.usuarios
mensajes = db.mensajes
#Iniciamos la aplicación de flask
app = Flask(__name__)

@app.route("/")
def home(): 
    return <meta http-equiv="refresh" content="1;url=https://navierasybuques.herokuapp.com/messages">

# Entregar todos los atributos de todos los mensajes en la bdd
#Recibe en la url los parametros id1 e id2 de dos usuarios y obtenga todos los mensajes entre ambos usuarios
@app.route("/messages")
def get_messages():
    uid1 = request.args.get('id1', False, int)
    uid2 = request.args.get('id2', False, int)
    if uid1 and uid2:
        messages = list(mensajes.find({"$or": [{"sender": uid1, "receptant": uid2}, {"sender": uid2, "receptant": uid1}]}, {"_id": 0}))
        if len(messages) > 0:
            return json.jsonify(messages)
        else:
            return json.jsonify({"ESrror": f'No existen mensajes entre usuarios con id {uid1} y {uid2}.'})
    else:
        results = list(mensajes.find({},{"_id":0}))
        return json.jsonify(results)

# Entrega info de un mensaje particular
@app.route("/messages/<int:mid>")
def get_message(mid):
    message = list(mensajes.find({"mid":mid},{"_id":0}))
    if len(message) > 0:
        return json.jsonify(message)
    else:
        return json.jsonify({"Error": f"No hay ningún mensaje con el id {mid}."})

#entrega la info de todos los usuarios
@app.route("/users")
def get_users():
    results = list(usuarios.find({},{"_id":0}))
    return json.jsonify(results)

#entrega la info de un usuario junto con sus mensajes emitidos 
@app.route("/users/<int:uid>")
def get_user(uid):
    users = list(usuarios.find({"uid":uid},{"_id":0}))
    if len(users) > 0:
        message = list(mensajes.find({"sender":uid},{"_id":0}))
        return json.jsonify(info_usuario = users, mensajes_usuario = message)
    else:
        return json.jsonify({"Error": f"El usuario con id {uid} no existe"})
    
# Rutas de búsqueda por texto
@app.route("/text-search")
def get_content_messages():
    if request.data:
        body = request.json
    else:
        return get_messages()
    id = False
    forbidden = False
    required = False
    desired =  False
    for key in SEARCH_KEYS:
        try:
            if isinstance(body[key], list):
                if len(body[key]) != 0:
                    if key == "required": 
                        required = True
                    elif key == "forbidden":
                        forbidden = True
                    elif key == "desired":
                        desired = True
                else:
                    body[key] = None
            elif isinstance(body[key], int):
                id = True
            else:
                body[key] = None
        except (KeyError, TypeError, BadRequest):
            body[key] = None
    # if not body["required"] and not body["desired"] and not body["forbidden"]:
    # if not required and not desired and not forbidden :
    #     return get_messages()
    # elif not body["required"] and not body["desired"] and body["forbidden"]:
    # elif not required and not desired and forbidden:
    #     print("3")
    #     query = list(map(lambda str: f"-{str}", body["forbidden"]))
    #     query = " ".join(query)
    #     search = list(mensajes.find({"$and" :
    #              [{"content": {'$regex': f'^((?!{i}).)*$', '$options' : 'i'}}
    #              for i in body["forbidden"]]}, {"_id": 0}))
    # else:
    db.mensajes.drop_indexes()
    db.mensajes.create_index( [('message', 'text')], default_language='none')
    query = list()
    if required:
        query += list(map(lambda str: f"\"{str}\"", body["required"]))
    if desired:
        query += body["desired"]
    if forbidden:
        query += list(map(lambda str: f"-{str}", body["forbidden"]))
    query = " ".join(query)
    if id:
        if isinstance(body["userId"], int):
            if required or desired and not forbidden:
                search = list(mensajes.find({"$text" : {"$search": query},"sender": body["userId"]}, {"_id": 0}))
            elif required or desired and forbidden:
                forb = " ".join(set(body["forbidden"]))
                all = list(mensajes.find({"sender": body["userId"]}, {"_id": 0}))
                to_delete = list(mensajes.find({"sender": body["userId"],
                                                "$text": {"$search": f"{forb}"}}, {"_id": 0}))
                search = [msg for msg in all if msg not in to_delete]
            elif forbidden:
                forb = " ".join(set(body["forbidden"]))
                all = list(mensajes.find({"sender": body["userId"]}, {"_id": 0}))
                to_delete = list(mensajes.find({"sender": body["userId"],
                                                "$text": {"$search": f"{forb}"}}, {"_id": 0}))
                search = [msg for msg in all if msg not in to_delete]
            else:
                search = list(mensajes.find({"sender": body["userId"]}, {"_id": 0}))
    else:  
        search = list(mensajes.find({"$text" : {"$search": query}}, {"_id": 0}))
        if required or desired and not forbidden:
                search = list(mensajes.find({"$text" : {"$search": query}}, {"_id": 0}))
        elif required or desired and forbidden:
            forb = " ".join(set(body["forbidden"]))
            all = list(mensajes.find({}, {"_id": 0}))
            to_delete = list(mensajes.find({"$text": {"$search": f"{forb}"}}, {"_id": 0}))
            search = [msg for msg in all if msg not in to_delete]
        elif forbidden:
            forb = " ".join(set(body["forbidden"]))
            all = list(mensajes.find({}, {"_id": 0}))
            to_delete = list(mensajes.find({"$text": {"$search": f"{forb}"}}, {"_id": 0}))
            search = [msg for msg in all if msg not in to_delete]
        else:
            search = list(mensajes.find({}, {"_id": 0}))
    # if not required and not desired and not forbidden and not id:
    #     return get_messages()
    return json.jsonify(search)


#     data = dict()
#     f_admitted = 0
#     f_forb = False
#     id = False
#     for key in SEARCH_KEYS:
#         try:
#             if isinstance(request.json[key], list):
#                 if len(request.json[key]) != 0:
#                     data[key] = request.json[key]
#                     if key == "required" or key == "desired":
#                         f_admitted += 1
#                     elif key == "forbidden":
#                         f_forb = True
#                 else:
#                     data[key] = None
#             elif isinstance(request.json[key], int):
#                 data[key] = request.json[key]
#                 id = True
#             else:
#                 data[key] = None

#         except (KeyError, TypeError, BadRequest):
#             data[key] = None

#     print(f"{f_admitted},{f_forb}, {id}")
#     # desired, required and forbidden empty or non existent
#     # id not int or non existent
#     if f_admitted == 0 and not f_forb and not id:
#         resultados = list(mensajes.find({}, {"_id": 0}))
#         return json.jsonify(resultados)

#     # desired, required and forbidden empty or non existent
#     # id exists
#     if f_admitted == 0 and not f_forb and id:
#         resultados = list(mensajes.find({"sender": data["userId"]}, {"_id": 0}))
#         return json.jsonify(resultados)

#     # only forbidden exists or is the only one not empty
#     # id not int or non existent
#     if f_admitted == 0 and f_forb and not id:
#         forb = " ".join(set(data["forbidden"]))
#         all = list(mensajes.find({}, {"_id": 0}))
#         to_delete = list(mensajes.find({"$text": {"$search": f"{forb}"}}, {"_id": 0}))
#         resultados = [msg for msg in all if msg not in to_delete]
#         return json.jsonify(resultados)

#     # only forbidden exists or is the only one not empty
#     # exists
#     if f_admitted == 0 and f_forb and id:
#         forb = " ".join(set(data["forbidden"]))
#         all = list(mensajes.find({"sender": data["userId"]}, {"_id": 0}))
#         to_delete = list(mensajes.find({"sender": data["userId"],
#                                         "$text": {"$search": f"{forb}"}}, {"_id": 0}))
#         resultados = [msg for msg in all if msg not in to_delete]
#         return json.jsonify(resultados)

#     # e.o.c
#     desired = ""
#     required = ""
#     forbidden = ""
#     if data["desired"]:
#         desired = " ".join(set(data["desired"]))

#     if data["required"]:
#         for frase in set(data["required"]):
#             required += f"\"{frase}\""

#     if data["forbidden"]:
#         forbidden = "-" + " -".join(set(data["forbidden"]))

#     search_string = desired + " " + required + " " + forbidden

#     if id:
#         resultados = list(mensajes.find({"sender": data["userId"], "$text": {"$search": f"{search_string}"}},
#                           {"_id": 0, "score": {"$meta": "textScore"}}).sort([('score', {'$meta': 'textScore'})]))
#     else:
#         resultados = list(mensajes.find({"$text": {"$search": f"{search_string}"}},
#                           {"_id": 0, "score": {"$meta": "textScore"}}).sort([('score', {'$meta': 'textScore'})]))

#     return json.jsonify(resultados)

@app.route("/messages", methods=['POST'])
def create_message():
    '''
    Crea un nuevo mensaje en la base de datos
    Se  necesitan todos los atributos de model, a excepcion de _id
    '''
    try:
        data = {key: request.json[key] for key in MENSAJES_KEYS}
       # siento que si o si hay una forma MAS EFICIENTE DE RECIBIR ESTO PERO NO LA PENSE PQ ESTABA APURADA
        count = mensajes.count_documents({})
        data["mid"] = count + 1
        result = mensajes.insert_one(data)
        if (result):
            message = f"Mensaje creado con mid:{count + 1}"
            success = True
        else:
            message = "No se pudo crear el mensaje"
            success = False
        return json.jsonify({"success":success, "message": message})
    except Exception as err:
        message = "Error en el mensaje"
        return json.jsonify({"success":False, "Error": message})
 
#Ruta de tipo DELETE
@app.route("/message", methods=['DELETE'])
def delete_message():
    '''
    Elimina el mensaje de id entregado
    '''
    mid = request.json['mid']
    if list(mensajes.find({"mid": mid})) != []:
        mensajes.remove({"mid": mid})
        return json.jsonify({"success": True})
    else:
        message = "No se pudo borrar el mensaje"
        return json.jsonify({"success": False, "message": message})


if __name__ == "__main__":
    app.run(debug=True)