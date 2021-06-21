import React, { useState, useEffect } from 'react'
import { View, Text, StyleSheet, TouchableOpacity, Animated, Dimensions, TextInput, ScrollView } from 'react-native'
import DatePicker from 'react-native-date-picker'
import BouncyCheckbox from "react-native-bouncy-checkbox";
import {Picker} from '@react-native-picker/picker'


const { height } = Dimensions.get('window')

const Modal = ({ show, close }) => {

  const [selectedLanguage, setSelectedLanguage] = useState();

  const [state, setState] = useState({
    opacity: new Animated.Value(0),
    container: new Animated.Value(height),
    modal: new Animated.Value(height),
  })

  const openModal = () => {
    Animated.sequence([
      Animated.timing(state.container, { toValue: 0, duration: 100 }),
      Animated.timing(state.opacity, { toValue: 1, duration: 300 }),
      Animated.spring(state.modal, { toValue: 0, bounciness: 5, useNativeDriver: true })
    ]).start()
  }

  const closeModal = () => {
    Animated.sequence([
      Animated.timing(state.modal, { toValue: height, duration: 250, useNativeDriver: true }),
      Animated.timing(state.opacity, { toValue: 0, duration: 300 }),
      Animated.timing(state.container, { toValue: height, duration: 100 })
    ]).start()
  }

  useEffect(() => {
    console.log(show)
    if(show){
      openModal()
    }else{
      closeModal()
    }
  }, [show])

  const [date, setDate] = useState(new Date())

  return( 
    <Animated.View 
      style={[styles.container, {
        opacity: state.opacity,
        transform: [
          { translateY: state.container }
        ]
      }]}
    >
      <Animated.View 
        style={[styles.modal, {
          transform: [
            { translateY: state.modal }
          ]
        }]}
      >
        <View style={styles.indicator} />
        <ScrollView>

        <Text style={{ fontSize: 24, fontWeight: 'bold', textAlign: 'center' }}>Nova Receita</Text>

       <Text>Descrição</Text>
       <TextInput placeholder="Adicionar"></TextInput>

       <Text>Valor</Text>
       <TextInput placeholder="R$0,00"></TextInput>

       <Text>Data de Vencimento</Text>
       <DatePicker
        date={date}
        onDateChange={setDate}
       />

       <Text>Recorrência</Text>
        <BouncyCheckbox
        text="Nenhuma"
        onPress={(isChecked: boolean) => {}}/>

        <BouncyCheckbox 
        text="Parcelada"
        onPress={(isChecked: boolean) => {}}/>

      <BouncyCheckbox 
      text="Mensal"
      onPress={(isChecked: boolean) => {}}/>

      <Text>Categoria</Text>

      <Picker
      selectedValue={selectedLanguage}
      onValueChange={(itemValue, itemIndex) => 
        setSelectedLanguage(itemValue)
      }>
        <Picker.Item label="Teste" value="teste"/>
        <Picker.Item label="OutroTeste" value="ot"/>
      </Picker>
      <Text>Conta</Text>
      <Picker
      selectedValue={selectedLanguage}
      onValueChange={(itemValue, itemIndex) => 
        setSelectedLanguage(itemValue)
      }>
        <Picker.Item label="Teste" value="teste"/>
        <Picker.Item label="OutroTeste" value="ot"/>
      </Picker>

      <Text>Situação</Text>
      <BouncyCheckbox
        text="A pagar"
        onPress={(isChecked: boolean) => {}}/>

        <BouncyCheckbox 
        text="Pago"
        onPress={(isChecked: boolean) => {}}/>

        <TouchableOpacity style={styles.btn} onPress={close}>
          <Text style={{ color: '#fff' }}>Salvar</Text>
        </TouchableOpacity>
        </ScrollView>
      </Animated.View>
    </Animated.View>
  )
}

const styles = StyleSheet.create({
  container: {
    width: '100%',
    height: '100%',
    backgroundColor: 'rgba(0, 0, 0, 0.5)',
    position: 'absolute'
  },
  modal: {
    bottom: 0,
    position: 'absolute',
    height: '100%',
    backgroundColor: '#fff',
    width: '100%',
    borderTopLeftRadius: 20,
    borderTopRightRadius: 20,
    paddingLeft: 25,
    paddingRight: 25
  },
  indicator: {
    width: 50,
    height: 5,
    backgroundColor: '#ccc',
    borderRadius: 50,
    alignSelf: 'center',
    marginTop: 5
  },
  text: {
    marginTop: 50,
    textAlign: 'center'
  },
  btn: {
    width: 100,
    height: 50,
    borderRadius: 10,
    backgroundColor: '#9b59b6',
    justifyContent: 'center',
    alignItems: 'center',
    marginTop:30,
    marginLeft: 115
  }
})

export default Modal