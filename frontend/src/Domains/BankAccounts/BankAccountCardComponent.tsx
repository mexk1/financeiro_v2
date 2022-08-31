import { BankAccount } from "../../types/BankAccount"

const BankAccountCardComponent = ( { bankAccount, onClick }:Props ) => {

  const handleClick = () => {
    onClick && onClick( bankAccount )
  }

  const classes = [
    'bg-white rounded-md shadow-md',
    'shadow-indigo-400 text-black',
    'w-full mx-4 flex items-center justify-center',
  ]

  return (
    <div className={ classes.join(' ') } onClick={ handleClick } >
      { bankAccount.name }
    </div>
  )
}

interface Props { 
  bankAccount: BankAccount,
  onClick?: ( a:BankAccount ) => void,
}

export default BankAccountCardComponent