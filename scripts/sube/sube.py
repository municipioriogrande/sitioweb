# -*- coding: utf-8 -*-

# Script para limpiar y juntar los puntos SUBE, descargados del sitio (ver info en personal wiki)
# se debe tener una carpeta llamada "puntos" con los archivos json allí


import os
from collections import namedtuple
import json
import csv
#import sqlite3 #cleaner and to practice
import requests
import datetime # today
from math import radians, cos, sin, asin, sqrt  #calculate distance coords points 

	
	
# ============	
# CONFIG
# ============	
	
FILES_POINTS_FOLDER = "puntos"
FIXES_FILENAME  = "puntos-fixes.json"
OUTPUT_FILENAME = "output.csv"
PROVINCE_CODE = "TF" #solo queremos Tierra del Fuego
BASE_SUBE_URL_REQUESTS = "https://tarjetasube.sube.gob.ar/subeweb//jsonPrivate/PointsWeb"
SAVE_JSON_RESULTS_CITIES = ("Río Grande",)
CALLES_YACARE = "calles-yacare.json"
CALLES_OSM    = "calles-osm.json"
OVERPASS_URL = "http://overpass-api.de/api/interpreter"


# ============	
# END CONFIG
# ============	




# ============	
# GLOBALS
# ============	

TODAY = datetime.date.today()
SUBE_Center      = namedtuple( 'SUBE_Center',      ['id', 'code', 'name', 'in_filter'] )
SUBE_Url_Request = namedtuple( 'SUBE_Url_Request', ['id', 'url', 'local_file'] )
Calle_Fixed_Id = namedtuple( 'Calle_Fixed_Id', ['name', 'id'] )

SUBE_REQUEST_HEADERS = { # funcional al 2018-10-24
	'__RequestVerificationSource': 'SrcRefW',
	'__RequestVerificationToken': 'UnxRe7EpjV_zVxgV0fY25DUgfvZTB6iXS085oGeN0lvwlCqmZSnH2U2oy_x8FYm8NDD_tktgGM_vfXKgloyi4969hfY1:OcY9Hb3qZrl-E7KWYPUoVo_L-b4DTIdIZoz4siAcCDXxBbOhNztSkqAO_Zq-ZL3iHc99mVTOfUrGkI6olgcPYC5CxBI1',
	'Cookie': 'ISAWPLB{53853465-02D3-4C86-8B44-C72C5BCAB6A1}={3D34D35A-2769-4FDA-9739-8086B0F319D5}; ASP.NET_SessionId=sb3gyy4gwhmm4xhlqa2maelh',
	}


SUBE_URLS_CATEGORIES = (
	SUBE_Url_Request('get',    BASE_SUBE_URL_REQUESTS + '/SearchTest?type[0]=1&type[1]=7', 'sube-puntos-obtencion.json'),
	SUBE_Url_Request('charge', BASE_SUBE_URL_REQUESTS + '/SearchTest?type[0]=2&type[1]=7', 'sube-puntos-carga.json'),
	SUBE_Url_Request('reg',    BASE_SUBE_URL_REQUESTS + '/SearchTest?type[0]=6&type[1]=7', 'sube-puntos-gestion.json'),
	SUBE_Url_Request('check',  BASE_SUBE_URL_REQUESTS + '/SearchTest?type[0]=4',           'sube-puntos-saldo-consulta.json'),
	SUBE_Url_Request('auth',   BASE_SUBE_URL_REQUESTS + '/SearchTest?type[0]=4',           'sube-puntos-saldo-acreditar.json'),
	SUBE_Url_Request('admin',  BASE_SUBE_URL_REQUESTS + '/SearchTest?type[0]=6&type[1]=7', 'sube-puntos-gestion.json'),
)
	
	
	
# de https://tarjetasube.sube.gob.ar/subeweb//jsonPrivate/SystemsWeb/GetCenterTypes
SUBE_CENTER_TYPES = (
  SUBE_Center(1, "OBT", "Obtención", True),
  SUBE_Center(2, "CAR", "Carga",     True),
  SUBE_Center(4, "TAS", "Terminal Automática",True),
  SUBE_Center(5, "AUT", "Autoservicio", False),
  SUBE_Center(6, "UGS", "Unidad de Gestión",   True),
  SUBE_Center(7, "CAS", "Centros de Atención", True),
)

'''
Puntos SUBE:
   Son locales comerciales, estaciones de tren y subte, agencias de lotería y correos en donde podés conseguir o cargar tu tarjeta.

Centros de Atención:
  Conseguir tu SUBE.
  Registrarla.
  Aplicar la Tarifa Social Federal en caso de ser beneficiario.
  Solicitar la baja de tu tarjeta por pérdida, robo o rotura.
  Recuperar tu saldo.
  Recibir asesoramiento sobre el servicio.
  Informarte sobre el estado de gestiones en curso.
  Actualizar tus datos.
  Asentar reclamos.
  Denunciar un Punto SUBE por cobro adicional.
  
Terminales Automáticas:
   Acreditar cargas electrónicas.
   Aplicar la Tarifa Social Federal.
   Consultar y recuperar tu saldo.
'''

# mapea los botones del mapa con sus categorias a los center_types. No es importante
SUBE_CENTER_TYPES_ACTIONS = requests.get(
   'https://tarjetasube.sube.gob.ar/subeweb//jsonPrivate/SystemsWeb/GetActionTypes', 
	headers=SUBE_REQUEST_HEADERS
	).json()
	
SUBE_POINTS      = list()
SUBE_POINTS_JSON = list()	


# Load Calles files
tmp = os.path.join(os.getcwd(), CALLES_YACARE)
if os.path.exists(tmp):
	with open(tmp, "r", encoding="utf-8") as input_file:
		
		try:
			CALLES_YACARE = json.loads(input_file.read())
		except:
			print ("error de lectura de archivo: " + CALLES_YACARE)


tmp = os.path.join( os.getcwd(), CALLES_OSM )
if os.path.exists(tmp):
	with open(tmp, "r", encoding="utf-8") as input_file:
		try:
			CALLES_OSM = json.loads(input_file.read())
			CALLES_OSM = CALLES_OSM["elements"]
		except:
			print ("error de lectura de archivo: " + CALLES_OSM)
else:
	# load from Overpass
	
	response = requests.get(
		OVERPASS_URL,
		params = {"data":
			"""
[out:json];
area[name="Río Grande"]["is_in:state"="Tierra del Fuego"][boundary=administrative];
( way(area)["highway"~"^(primary|secondary|tertiary|residential)$"]["name"]; );
out body;
>;
out skel qt;
			"""
			}
		)
		
	CALLES_OSM = response.json()
	tmp_osm    = response.json()
	CALLES_OSM["elements"] = list()
	
	for i,item in enumerate(tmp_osm["elements"]):
		# we don't want nodes. For some kind of reason, we cannot remove them in query...
		if item["type"] == "node":
			#del CALLES_OSM["elements"][i]
			continue
		CALLES_OSM["elements"].append(item)
		
	with open(tmp, "w", encoding="utf-8") as output_file:
		json.dump(CALLES_OSM, output_file, indent=2)
	
	CALLES_OSM = CALLES_OSM["elements"]
	print(" !! updated OSM streets ")



	

# remove duplicates, only add names as we have different "ids"* and it's a manual process
# * because streets can be "cut" and OSM treats them with different IDs
# actually, change it so we use a list with [list ids, name, name_alt ] so we can pick any

tmp_orig = CALLES_OSM
CALLES_OSM = list()

for item in tmp_orig:
	search_name = item["tags"]["name"]
	search_name_alt = ""
	
	if "short_name" in item["tags"]:
		search_name_alt = item["tags"]["short_name"]
	
	
	tmp = CALLES_OSM[:]
	
	for i,list_item in enumerate(tmp):
		if search_name in list_item:
			CALLES_OSM[i][0].append(str(item["id"]))
			break
	else:
		tmp_ids = list()
		tmp_ids.append(str(item["id"]))
		
		tmp_list_item = list()
		tmp_list_item.append(tmp_ids)
		tmp_list_item.append(search_name)
		tmp_list_item.append(search_name_alt)
		
		
		CALLES_OSM.append(
			tmp_list_item
		)



CALLES_FIXES_YACARE = (
	#wrong , yacareID
	Calle_Fixed_Id("AMEGHINO",                  "7"),
	Calle_Fixed_Id("ANTARTIDA ARGENTINA",       "10"),
	Calle_Fixed_Id("AV. JUAN DOMINGO PERÓN NORTE", "158"),
	Calle_Fixed_Id("AV. SAN MARTIN",           "182"),
	Calle_Fixed_Id("BAHIA SAN JULIAN",         "612"),
	Calle_Fixed_Id("BELGRANO AV.",             "17"),
	Calle_Fixed_Id("BELISARIO ROLDAN",         "173"),
	Calle_Fixed_Id("BERNARDO O'HIGGINS",       "147"),
	Calle_Fixed_Id("BROWN ALMTE.",             "24"),
	Calle_Fixed_Id("CMTE. LUIS PIEDRABUENA",   "160"),
	Calle_Fixed_Id("Calle Pres. Bernardino Rivadavia", "169"), 
	Calle_Fixed_Id("DR. ALBERT SCHWEITZER",     "188"),
	Calle_Fixed_Id("ENRIQUE ARTECHE",          "11"),
	Calle_Fixed_Id("ESTRADA",                  "55"),
	Calle_Fixed_Id("Eva Peron",                "57"),
	Calle_Fixed_Id("FAGNANO",                  "58"),
	Calle_Fixed_Id("FUEGUINOS PROS.",          "161"),
	Calle_Fixed_Id("Gdor. Felix Paz",          "67"),
	Calle_Fixed_Id("HALCON PEREGRINO",         "409"),
	Calle_Fixed_Id("HERMANA TAPARELLO",        "387"),
	Calle_Fixed_Id("HERMANA TAPPARELLO",       "387"),
	Calle_Fixed_Id("J.B. THORNE",              "197"),
	Calle_Fixed_Id("JOSÉ M. ESTRADA",          "55"),
	Calle_Fixed_Id("JUAN B. THORNE",           "197"),
	Calle_Fixed_Id("JUAN R. FALCONIER",        "606"),
	Calle_Fixed_Id("KEKOMBOSCH",               "105"),
	Calle_Fixed_Id("KEKOMBOSH",                "105"),
	Calle_Fixed_Id("L. ROSALES",               "174"),
	Calle_Fixed_Id("LINIERS",                  "118"),
	Calle_Fixed_Id("LOS COHIUES",              "233"),
	Calle_Fixed_Id("Lasserre",                 "114"),
	Calle_Fixed_Id("Av. Leandro N. Alem",      "6"),
	Calle_Fixed_Id("MARIA AUXILIADORA",        "133"),
	Calle_Fixed_Id("MONSEÑOR FAGNANO",         "58"),
	Calle_Fixed_Id("Maipu Av.",                "131"),
	Calle_Fixed_Id("O HIGGINS",                "147"),
	Calle_Fixed_Id("Obligado",                 "146"),
	Calle_Fixed_Id("PCIAS. UNIDAS",            "165"),
	Calle_Fixed_Id("PELLEGRINI",               "156"),
	Calle_Fixed_Id("PERITO MORENO AV.",        "157"),
	Calle_Fixed_Id("Perito F P Moreno",        "157"),
	Calle_Fixed_Id("PERU",                     "159"),
	Calle_Fixed_Id("PLAYERO RABADILLA BLANCA", "412"),
	Calle_Fixed_Id("PRES. B. RIVADAVIA",       "169"), 
	Calle_Fixed_Id("Paz Gobernador",           "67"),
	Calle_Fixed_Id("Paz Gdor.",                "67"),
	Calle_Fixed_Id("QUIROGA FACUNDO",          "281"),
	Calle_Fixed_Id("Quiroga Facundo",          "281"),
	Calle_Fixed_Id("RICARDO BALBIN",           "322"),
	Calle_Fixed_Id("RIVADAVIA",                "169"),
	Calle_Fixed_Id("RIO GRANDE",               "424"),
	Calle_Fixed_Id("SAN MARTIN AV.",           "182"),
	Calle_Fixed_Id("Av. San Martín",           "182"),
	Calle_Fixed_Id("SANTA DOMINGA MAZARELL",   "389"),
	Calle_Fixed_Id("SARMIENTO D. F.",          "263"),
	Calle_Fixed_Id("TTE. PRIMERO BERNHARDT",   "232"),
	Calle_Fixed_Id("USUHAIA",                  "203"),
	Calle_Fixed_Id("VUKASOVIC G.",             "254"),
	Calle_Fixed_Id("YAHALVE (EX PUYEN)",       "321"),
	)


	
	
CALLES_FIXES_OSM = (
	Calle_Fixed_Id("28 DE MAYO",            "431110336"),
	Calle_Fixed_Id("AMEGHINO",               "237147488"),
	Calle_Fixed_Id("AV. JUAN DOMINGO PERÓN NORTE", "113988015"),
	Calle_Fixed_Id("AV. SAN MARTÍN",         "113988021"),
	Calle_Fixed_Id("BAHIA SAN JULIAN",       "207357065"),
	Calle_Fixed_Id("BELGRANO AV.",           "41284842"),
	Calle_Fixed_Id("BELISARIO ROLDAN",       "113991890"),
	Calle_Fixed_Id("O HIGGINS",              "49686535"),
	Calle_Fixed_Id("BERNARDO O'HIGGINS",     "49686535"),
	Calle_Fixed_Id("BROWN ALMTE.",           "114099103"),
	Calle_Fixed_Id("CALLE PRES. BERNARDINO RIVADAVIA", "113990357"),
	Calle_Fixed_Id("CMTE. LUIS PIEDRABUENA", "113990360"),
	Calle_Fixed_Id("DR. ALBERT SCHWEITZER",  "113991888"),
	Calle_Fixed_Id("FAGNANO",                "113991889"),
	Calle_Fixed_Id("MONSEÑOR FAGNANO",       "113991889"),
	Calle_Fixed_Id("FUEGUINOS PROS.",        "114095582"),
	Calle_Fixed_Id("HALCON PEREGRINO",       "159212128"),
	Calle_Fixed_Id("HERMANA TAPARELLO",      "595200592"),
	Calle_Fixed_Id("HERMANA TAPPARELLO",     "595200592"),
	Calle_Fixed_Id("J.B. THORNE",            "41285307"),
	Calle_Fixed_Id("JUAN B. THORNE",         "41285307"),
	Calle_Fixed_Id("JOSÉ M. ESTRADA",        "114091241"),
	Calle_Fixed_Id("JUAN R. FALCONIER",      "207357087"),
	Calle_Fixed_Id("KEKOMBOSCH",             "114796341"),
	Calle_Fixed_Id("KEKOMBOSH",              "114796341"),
	Calle_Fixed_Id("L. ROSALES",             "49686529"),
	Calle_Fixed_Id("LINIERS",                "114091213"),
	Calle_Fixed_Id("MARIA AUXILIADORA",      "114099104"),
	Calle_Fixed_Id("PCIAS. UNIDAS",          "114091166"),
	Calle_Fixed_Id("PELLEGRINI",             "237059940"),
	Calle_Fixed_Id("PERITO MORENO AV.",      "113987994"),
	Calle_Fixed_Id("PERU",                   "159220290"),
	Calle_Fixed_Id("PLAYERO RABADILLA BLANCA", "159212133"),
	Calle_Fixed_Id("QUIROGA FACUNDO",        "158598556"),
	Calle_Fixed_Id("RIO GRANDE",             "158598549"),
	Calle_Fixed_Id("RIO PIPO",               "207357076"),
	Calle_Fixed_Id("SAN MARTIN AV.",         "113988021"),
	Calle_Fixed_Id("SANTA DOMINGA MAZARELL", "595200593"),
	Calle_Fixed_Id("SARMIENTO D. F.",        "114091265"),
	Calle_Fixed_Id("TTE. PRIMERO BERNHARDT", "114091168"),
	Calle_Fixed_Id("USUHAIA",                "114102387"),
	Calle_Fixed_Id("VUKASOVIC G.",           "158614245"),
	Calle_Fixed_Id("YAHALVE",                "114796350"),
	Calle_Fixed_Id("YAHALVE (EX PUYEN)",     "114796350"),
	Calle_Fixed_Id("EVA PERON",              "311587736"),
)	
	
	
	
	
	
	
WORD_FIXES = (
	#("Maria","María"),
	#("Bahia","Bahía"),
	(" De "," de "),
	#("Av. ",""),
	#(" Av. ",""),
	#("Peron","Perón"),
	#("Perito F P Moreno","Perito Moreno"),
	#("Perito Francisco Moreno","Perito Moreno"),
	(" Y "," y "),
	#("Antartida","Antártida"),
	("  "," "),
	#("Gdor. ","Gobernador "),
	#("",""),
	#("",""),
	#("",""),
	)



def get_sube_center_type(center_id):
	
	for center in SUBE_CENTER_TYPES:
		if center.id == center_id:
			return center.name

	return center_id

	
def accents_string_remove(text):

	return text.replace("ó","o").replace("í","i").replace("é","i")
	


def apply_word_fixes(text):
	tmp = text
	
	for word in WORD_FIXES:
		text = text.replace(word[0],word[1])
	
	return text
	



def apply_street_fixes(street):
	# extract street name (we suppouse is always last)
	
	
	if " y " in street.lower():
		return street.title()
	
	number = street.rsplit(" ", maxsplit=1).strip()	
	numberless_street = street.replace(" " + number, "").strip()
	
	
	for street in CALLES_FIXES_OSM:
		real_street_name = ""
		
		if numberless_street.lower() != street.name.lower():
			continue
			
		for street_item in CALLES_OSM:
			
			if street.id in street_item[0]:
				return street_item[1]  + " " + number
				break
	
	return numberless_street.title() + " " + number
	
	
	
	
	for street in CALLES_FIXES_YACARE:
		real_street_name = ""
		
		if numberless_street.lower() != street.name.lower():
			continue
		
		for street_item in CALLES_YACARE:
			if street.id == street_item["yacareID"]:
				real_street_name = street_item["name"]
				break
	
		if real_street_name:
			numberless_street = real_street_name
	
	return numberless_street + " " + number
	


def haversine(point1,point2):
    """
    Calculate the great circle distance between two points 
    on the earth (specified in decimal degrees)
	 
	 from: https://stackoverflow.com/questions/4913349/haversine-formula-in-python-bearing-and-distance-between-two-gps-points
	 
    """
    # convert decimal degrees to radians 
    lon1, lat1, lon2, lat2 = map(radians, [point1[1], point1[0], point2[1], point2[0]])

    # haversine formula 
    dlon = lon2 - lon1 
    dlat = lat2 - lat1 
    a = sin(dlat/2)**2 + cos(lat1) * cos(lat2) * sin(dlon/2)**2
    c = 2 * asin(sqrt(a)) 
    r = 6371 # Radius of earth in kilometers. Use 3956 for miles
    return c * r


	
	
	
# ============	
# END GLOBALS
# ============	




# ============	
# PROGRAM START!
# ============		
	
	
sube_points_data_by_cat = {
	'get'    : "",
	'charge' : "",
	'reg'    : "",
	'check'  : "",
	'auth'   : "",
	'admin'  : ""
}


checked_folder = False 
if os.path.exists(FILES_POINTS_FOLDER):
	checked_folder = True


print(" Getting data... ")	
# try to get responses, otherwise load from files (probably outdated)	
for item in SUBE_URLS_CATEGORIES:
	response = requests.get(item.url, headers=SUBE_REQUEST_HEADERS)
	the_file_path = os.path.join(os.getcwd(), FILES_POINTS_FOLDER, item.local_file)
	the_file_last_modified = datetime.date.fromtimestamp(os.path.getmtime(the_file_path))

	if response.status_code == requests.codes.ok:
		response_content = response.json()
		
		sube_points_data_by_cat[item.id] = response_content['Data']
		sube_points_data_by_cat[item.id][0]["origin"] = "request"
		
		if not checked_folder:		
			print(" Carpeta source no existe. No se puede guardar los resultados. Skipping. ")
		else:	
			if the_file_last_modified < (TODAY - datetime.timedelta(4)):
				with open(the_file_path, "w", encoding="utf-8") as output_file:
					json.dump(response_content,output_file)


	else: 
		print("No se pudo cargar de " + item.url)
	
		if not checked_folder:
			print(" Carpeta source no existe. No se pueden leer los resultados localmente ")
			exit()
		
		if not the_file_path.endswith(".json"):
			print (the_file + " no es archivo valido")
			continue
			
		the_file_json = ""
		with open(the_file_path, 'r', encoding="utf-8") as input_file:

			try:
				the_file_json = json.loads(input_file.read())
			except:
				print ("error de lectura de archivo: " + item.local_file)
				continue	
	
		print("Cargando localmente, ultima modif. " + str(the_file_last_modified) + "\n")
		
		sube_points_data_by_cat[item.id] = the_file_json
		sube_points_data_by_cat[item.id][0]["origin"] = "local"




FIXES_FILE = ""
tmp = os.path.join(os.getcwd(), FIXES_FILENAME)
if os.path.exists(tmp):
	with open(tmp, "r", encoding="utf-8") as input_file:
		
		try:
			FIXES_FILE = json.loads(input_file.read())
		except:
			print ("error de lectura de archivo: " + FIXES_FILENAME)




# ok, now, if we have source file, load it and update it 
base_data_file = ""
BASE_DATA_FILE_UPDATED = False 

print(" Loading local csv... ")	
tmp = os.path.join(os.getcwd(), OUTPUT_FILENAME)

CSV_HEADERS = ""


if os.path.exists(tmp):

	if not OUTPUT_FILENAME.endswith(".csv"):
		print("Archivo base debe ser CSV, se obtuvo " + OUTPUT_FILENAME)
		exit()

	with open(tmp, "r", encoding="utf-8", newline="") as input_file:
		base_data_file = csv.DictReader(input_file)
		CSV_HEADERS = base_data_file.fieldnames
		
		ctr = 0
		
		for row in base_data_file:
			tmp_point = dict()
			ctr += 1
		
			for csv_head in CSV_HEADERS:
				tmp_point[csv_head] = row[csv_head]
				
			#tmp_point['denunciable'] = True if row['denunciable'].lower() == "true" else False
			#tmp_point['address'] = apply_street_fixes(tmp_point['address'])
			
			if tmp_point["is_estacionamiento-medido"] == "si":
				tmp_point['ping'] = True
			else:
				tmp_point['ping'] = False
			
				
			
			SUBE_POINTS.append(tmp_point)	
			
		
		print(" total csv loaded : " , ctr)


		
		
print(" Parsing data... ")	
RAW_JSON_RG = list()

for item_code, json_file in sube_points_data_by_cat.items():

	if not json_file:
		print(" skipping " + item_code )
		continue
		
	json_file_origin = json_file[0]['origin']
	
	
	for json_node in json_file:
	
		if not json_node["provincia"] == PROVINCE_CODE:
			continue
		'''
		if json_node['localidad'].lower() in ("rio grande", "río grande", "san sebastián"):
			RAW_JSON_RG.append(json_node)
		'''

		# search, if found, merge/update
		current_id = json_node['EmpresaId']
		if "|" in json_node['EmpresaId']:
			current_id = json_node['EmpresaId'].split("|")[0]	

		current_location    = json_node['Location'].replace("\t", " ").replace("\u00A0"," ").replace("  "," ").strip()
		current_location    = apply_street_fixes(current_location)
		current_location    = apply_word_fixes(current_location)
		current_description = apply_word_fixes(json_node['Description'].title())
		current_center_type = get_sube_center_type(json_node['Type'])
		current_place_type  = json_node['BranchType'].title()
		
		if json_node['localidad'].lower() in ("rio grande", "río grande", "san sebastián"):
			json_node['localidad'] = "Río Grande"
		
		sube_points_original = SUBE_POINTS[:]
		
		for i,item in enumerate(sube_points_original):
				
			if item['id'] == current_id:

				item['ping'] = True  # ALIIIVEEEE
				
				#merge
				if item['address'] != current_location and item['locked'] != "si":
					SUBE_POINTS[i]['address'] = current_location
					
					if base_data_file:
						BASE_DATA_FILE_UPDATED = True
				
				tmp_geocoords = item['geocoord'].split(",")
				if tmp_geocoords[0] != json_node['lat'] or tmp_geocoords[1] != json_node['lgn'] :
					distance = haversine(
										(float(tmp_geocoords[0]), float(tmp_geocoords[1])),
										(float(json_node['lat']), float(json_node['lgn']))
									)
	
					if distance > 0.15 and item['locked'] != "si" and item['checked'] != "si":
						print ("\n\n  Mismo place ID pero distinto geocord. Manual check! id: " + item['id'])
						print(" !!! 1 !!! ", json.dumps(item, indent=2, sort_keys=True))
						print(" !!! 2 !!! ", json.dumps(json_node, indent=2, sort_keys=True))
						print(" distancia: " , distance )
				
				if item['description'] != current_description and item['locked'] != "si":
					SUBE_POINTS[i]['description'] = current_description
					if base_data_file:
						BASE_DATA_FILE_UPDATED = True
						
				if item['open_times'] != json_node['time']:
					SUBE_POINTS[i]['open_times'] = json_node['time'].lower()
					if base_data_file:
						BASE_DATA_FILE_UPDATED = True
						
				if item['center_type'] != current_center_type:
					if (not base_data_file) or (base_data_file and not current_center_type in SUBE_POINTS[i]['center_type']):
						SUBE_POINTS[i]['center_type'] += ", " + current_center_type
					
						if base_data_file:
							BASE_DATA_FILE_UPDATED = True
						
				if item['place_type'] != current_place_type:
					if (not base_data_file) or (base_data_file and not current_place_type in SUBE_POINTS[i]['place_type']):				
						SUBE_POINTS[i]['place_type'] += ", " + current_place_type
						
						if base_data_file:
							BASE_DATA_FILE_UPDATED = True
				
				tmp_denunciable = True if item['denunciable'].lower() == "true" else False
				if tmp_denunciable != json_node['Denunciable']:
					print ("  Mismo place ID pero distinto valor en denunciable. Manual check! id: " + item['id'])
					print("\n\n !!! 1 !!!", json.dumps(item, indent=2, sort_keys=True))
					print("\n !!! 2 !!! ",  json.dumps(json_node, indent=2, sort_keys=True))
					
				if item['from_file'] != item_code:
					if (not base_data_file) or (base_data_file and not item_code in SUBE_POINTS[i]['from_file']):	
						SUBE_POINTS[i]['from_file'] += ", " + item_code

						if base_data_file:
							BASE_DATA_FILE_UPDATED = True
				
				if BASE_DATA_FILE_UPDATED:
					SUBE_POINTS[i]['origin'] = json_file_origin	
					SUBE_POINTS[i]['last_updated'] = str(TODAY)
					
				break
				
		else:
			#add
			
			tmp_point = dict()
			point_special_cases = (
					"id", "address", "geocoord", "description", "open_times", 
					"city", "center_type", "place_type", "from_file", "origin",
					"checked", "locked", "name", "zona", "is_estacionamiento-medido", "denunciable", "last_updated"
				)
			
			for csv_head in CSV_HEADERS:
				if csv_head in point_special_cases:
				
					if csv_head == "id":
						tmp_point[csv_head] = current_id

					if csv_head == "address":
						tmp_point[csv_head] = current_location

					if csv_head == "geocoord":
						tmp_point[csv_head] = json_node['lat'] + "," + json_node['lgn']
						
					if csv_head == "description":
						tmp_point[csv_head] = current_description
						
					if csv_head == "open_times":
						tmp_point[csv_head] = json_node['time'].lower()
						
					if csv_head == "city":
						tmp_point[csv_head] = json_node['localidad'].title()

					if csv_head == "center_type":
						tmp_point[csv_head] = current_center_type

					if csv_head == "place_type":
						tmp_point[csv_head] = current_place_type

					if csv_head == "from_file":
						tmp_point[csv_head] = item_code

					if csv_head == "origin":
						tmp_point[csv_head] = json_file_origin

					if csv_head == "denunciable":
						tmp_point[csv_head] = str(json_node['Denunciable'])
						
					if csv_head in ("checked", "name", "zona", "is_estacionamiento-medido", "last_updated", "locked"):
						continue
						
				else:
					tmp_point[csv_head] = json_node[csv_head]
					
			tmp_point['name'] = ""
			tmp_point['last_updated'] = str(TODAY)
			tmp_point['ping'] = True
			tmp_point['checked'] = ""
			tmp_point['locked'] = ""
			tmp_point['zona'] = ""
			tmp_point['is_estacionamiento-medido'] = "no"
			
			
			SUBE_POINTS.append(tmp_point)
		
		
'''
with open(os.path.join(os.getcwd(),"raw-rg.json"),"w",encoding="utf-8") as tmp:
	json.dump(RAW_JSON_RG, tmp)
'''
		
#apply fixes
for fix in FIXES_FILE:
	for i,_ in enumerate(SUBE_POINTS):
		
		if fix['id'] != SUBE_POINTS[i]['id']:
			continue
			
		if SUBE_POINTS[i]['locked']:
			continue
			
		for key, value in fix.items():
			if not key == "id":
				SUBE_POINTS[i][key] = value
				
			if key == "name" and SUBE_POINTS[i]['name'] and SUBE_POINTS[i]['description']:
				if accents_string_remove(SUBE_POINTS[i]['name'].lower()) == accents_string_remove(SUBE_POINTS[i]['description'].lower()) :
					SUBE_POINTS[i]['description'] = ""


# ping estacionamiento medido items 
# remove not pinged points	
tmp = SUBE_POINTS[:]		
for i, item in enumerate(tmp):

	if not item['ping']:
		print("\n\n !!! deprecating: ", json.dumps(item, indent=2, sort_keys=True))
		del SUBE_POINTS[i]
		BASE_DATA_FILE_UPDATED = True



if base_data_file and not BASE_DATA_FILE_UPDATED:
	print(" No hubieron cambios en los datos.")
	exit()
	



	
print(" total requested/final : " , len(SUBE_POINTS))

	
with open(os.path.join( os.getcwd(), OUTPUT_FILENAME ), "w", encoding="utf-8", newline="") as file_output:
	# newline="" needed so it doesnt write in everyother line
	csv_writer = csv.writer(file_output, delimiter=",", quotechar='"', quoting=csv.QUOTE_ALL)
	csv_writer.writerow(CSV_HEADERS)

	
	tmp_point = list()
	for point in SUBE_POINTS:
		tmp_point = list()

		for csv_head in CSV_HEADERS:
			
			tmp_point.append(point[csv_head])
		
		csv_writer.writerow(tmp_point)




tmp = list()
tmp_only_cities = dict()

for point in SUBE_POINTS:
	tmp.append(point)
	
	for key in SAVE_JSON_RESULTS_CITIES:
		if key not in tmp_only_cities:
			tmp_only_cities[key] = list()
			
		if point['city'].lower() == key.lower():
			tmp_only_cities[key].append(point)
		

with open(os.path.join(os.getcwd(), "puntos-tdf.json"), "w", encoding="utf-8" ) as file_output:
	json.dump(tmp,file_output)


for key in SAVE_JSON_RESULTS_CITIES:
	tmp = key.replace(" ","-").lower()
	tmp = accents_string_remove(tmp)
	
	with open(os.path.join(os.getcwd(), "puntos-" + tmp + ".json"), "w", encoding="utf-8") as file_output:
		json.dump(tmp_only_cities[key],file_output)
