/**
 * Sample React Native App
 * https://github.com/facebook/react-native
 *
 * @format
 * @flow strict-local
 */

import React, { useState } from 'react';
import type {Node} from 'react';
import {
  Text,
  SafeAreaView,
  StyleSheet,
  View,
  TouchableOpacity,
} from 'react-native';
import Modal from './telas/Receitas'

const App: () => Node = () => { 

  const [modal, setModal] = useState(false)

  return (
    <SafeAreaView style={styles.container}>
      <View style={styles.box}>
        <Text style={styles.textoBonitinho1}>Visão Geral</Text>
        <View style={{ flexDirection: 'row', flexWrap: 'wrap', top: 30 }}>
          <TouchableOpacity
          onPress={() => setModal(true)}
          style={styles.roundedButton1}>
            <Text>+</Text>
          </TouchableOpacity>
          <Text style={{ marginTop: 50, marginRight: 50, fontWeight: 'bold', fontSize: 18 }}>Receitas</Text>
        </View>
        <View style={{ flexDirection: 'row', flexWrap: 'wrap', bottom: 15 }}>
          <TouchableOpacity 
          style={styles.roundedButton2}>
            <Text>-</Text>
          </TouchableOpacity>
          <Text style={{ marginTop: 50, marginRight: 50, fontWeight: 'bold', fontSize: 18 }}>Despesas</Text>
        </View>
      </View>
      <Modal
        show={modal}
        close={() => setModal(false)}
      />
    </SafeAreaView>
  )
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    backgroundColor: '#778899',
  },

  box: {
    "position": "absolute",
    "width": 315,
    "height": 271,
    "left": 39,
    "top": 212,
    "backgroundColor": "#ffffff",
    "shadowOffset": {
      "width": 0,
      "height": 9
    },
    "shadowRadius": 50,
    "shadowColor": "rgba(0, 0, 0, 0.1)",
    "shadowOpacity": 1,
    "borderTopLeftRadius": 40,
    "borderTopRightRadius": 40,
    "borderBottomRightRadius": 40,
    "borderBottomLeftRadius": 40,
  },

  roundedButton1: {
    width: 45,
    height: 45,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 5,
    margin: 43,
    borderRadius: 100,
    color: '#ffffff',
    backgroundColor: '#32cd32',
  },

  roundedButton2: {
    width: 45,
    height: 45,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 5,
    margin: 43,
    borderRadius: 100,
    color: '#ffffff',
    backgroundColor: '#cd5c5c',
  },

  textoBonitinho1: {
    left: 63,
    top: 15,
    fontSize: 16,
    fontFamily: 'Montserrat',
    fontWeight: 'bold'
  }
});

export default App;
