import { Card } from "../../types/Card"

const CardCardComponent = ( { card, onClick }:Props ) => {

  const handleClick = () => {
    onClick && onClick( card )
  }

  const classes = [
    'bg-white rounded-md shadow-md h-40',
    'shadow-indigo-400 text-black flex-col',
    'w-full mx-4 flex items-center justify-center',
  ]

  return (
    <div className={ classes.join(' ') } onClick={ handleClick } >
      <span>
        { card.name } - { card.mode }
      </span>
      <span>
        **** **** **** { card.last_digits }
      </span>
    </div>
  )
}

interface Props { 
  card: Card,
  onClick?: ( a:Card ) => void,
}

export default CardCardComponent