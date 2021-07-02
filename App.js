/**
 * Sample React Native App
 * https://github.com/facebook/react-native
 *
 * @format
 * @flow strict-local
 */

import React from 'react';
import type {Node} from 'react';
import {
  Text,
  Alert,
  SafeAreaView,
  StyleSheet,
  View,
  TouchableOpacity,
} from 'react-native';

const App: () => Node = () => {  
  return (
    <SafeAreaView style={styles.container}>
      <View style={styles.box}>
        <TouchableOpacity 
        style={styles.roundedButton1}>
          <Text>+</Text>
        </TouchableOpacity>
      </View>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    backgroundColor: '#32cd32',
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
    "borderBottomLeftRadius": 40
  },

  roundedButton1: {
    width: 60,
    height: 50,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 10,
    borderRadius: 100,
    backgroundColor: '#32cd32',
  }
});

export default App;
