import React, { useCallback, useState } from "react"
import { useMemo } from "react"
import Modal, { ModalProps } from "../components/Modal"

const useModal = () => {

  const [ isOpen, setIsOpen ] = useState( false )

  const Component = useMemo( ( ) => {

    return ( props:ModalProps ) => {
      const realProps:ModalProps = {
        ...props,
        isOpen,
        onClose: () => setIsOpen( false )
      }
      return (
        <Modal { ...realProps } />
      )
    }
  }, [ isOpen ] )

  const open = useCallback( () => {
    setIsOpen( true )
  }, [ ] )

  const close = useCallback( () => {
    setIsOpen( false )
  }, [  ] )

  return {
    Component,
    open,
    close
  }
}

export default useModal