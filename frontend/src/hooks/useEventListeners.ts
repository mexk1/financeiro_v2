import { useCallback, useEffect } from "react"


type HandlerProps = ( e:any ) => void

interface Props {
  node?:Node | Window, 
  event: string,
  handler: HandlerProps,
  condition?: boolean
}

const useEventListener = ( props:Props  ) => {
    
  const { node, event, handler, condition = true } = props 

  const add = useCallback( () => {
    ( node || window ).addEventListener( event, handler )
  }, [ event, handler, node ] )

  const remove = useCallback( () => {
    ( node || window ).removeEventListener( event, handler )
  }, [ event, handler, node ] )

  useEffect( () => {
    condition && add()
  }, [ add, condition ] )

  useEffect( () => {
    console.log( `condition`, condition )
  }, [ condition ] )

  useEffect( () => {
    return remove
  }, [ remove ] )

  return {
    remove,
    add
  }
}

export default useEventListener